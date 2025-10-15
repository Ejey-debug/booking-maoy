<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Show the reservation form.
     */
    public function create()
    {
        return view('pages.reserve');
    }

    /**
     * Check available rooms between dates.
     */
    public function checkAvailability(Request $request)
    {
        $checkIn  = $request->input('check_in_date');
        $checkOut = $request->input('check_out_date');

        $rooms = Room::whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut) {
            $query->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                  ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                      $q2->where('check_in_date', '<', $checkIn)
                         ->where('check_out_date', '>', $checkOut);
                  });
            });
        })->get();

        return view('pages.availability', compact('rooms', 'checkIn', 'checkOut'));
    }

    /**
     * Store a reservation with uploaded payment proof.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'room_id'        => 'required|exists:rooms,id',
                'check_in_date'  => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
                // payment_proof is optional now (we use reference_number / payment_mode)
                'payment_proof'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'reference_number' => 'nullable|string|max:255',
                'payment_mode'     => 'nullable|string|max:100',
                'addons'           => 'array',
                'addons.*'         => 'string',
                'name'             => 'nullable|string|max:255',
                'email'            => 'nullable|email|max:255',
                'contact'          => 'nullable|string|max:30',
                'guests'           => 'nullable|integer|min:1',
            ]);

            // ensure value is present in payload
            $validated['payment_mode'] = $validated['payment_mode'] ?? $request->input('payment_mode');
            $validated['reference_number'] = $validated['reference_number'] ?? $request->input('reference_number');
            $validated['addons'] = $validated['addons'] ?? $request->input('addons');

            // Handle file upload
            if ($request->hasFile('payment_proof')) {
                $validated['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
            }

            // --- safe total computation (room*nights + addons) ---
            $selectedAddons = $request->input('addons', []);
            $selectedAddons = is_array($selectedAddons) ? $selectedAddons : (empty($selectedAddons) ? [] : explode(',', $selectedAddons));

            $addonPrices = [
                'Jetski Rental' => 5000,
                'Atv' => 1000,
            ];

            $addonsTotal = 0;
            foreach ($selectedAddons as $addon) {
                if (isset($addonPrices[$addon])) {
                    $addonsTotal += (float) $addonPrices[$addon];
                }
            }

            $room = Room::find($request->room_id);
            $roomPrice = max(0, (float) optional($room)->price);
            $nights = 1;
            if ($request->filled('check_in_date') && $request->filled('check_out_date')) {
                try {
                    $nights = \Carbon\Carbon::parse($request->check_out_date)
                        ->diffInDays(\Carbon\Carbon::parse($request->check_in_date));
                    $nights = max(1, (int)$nights);
                } catch (\Exception $e) {
                    $nights = 1;
                }
            }

            // ensure non-negative final total
            $calculatedTotal = max(0, ($roomPrice * $nights) + $addonsTotal);

            $validated['addons'] = $selectedAddons;
            $validated['total_price'] = $calculatedTotal;
            // --- end safe computation ---

            // store addons as an array (not a JSON string) so views can render without "[]"
            $validated['addons'] = is_array($selectedAddons) ? $selectedAddons : (empty($selectedAddons) ? [] : explode(',', $selectedAddons));

            // Ensure required DB columns have values (hotfix)
            $validated['user_id'] = $validated['user_id'] ?? null;
            $validated['name']    = $validated['name']    ?? 'Guest';
            $validated['email']   = $validated['email']   ?? 'no-email@local';
            $validated['contact'] = $validated['contact'] ?? '0000000000';
            $validated['guests']  = $validated['guests']  ?? 1;

            $reservation = Reservation::create($validated);

            // send confirmation email (non-blocking safe send)
            try {
                if (!empty($reservation->email)) {
                    \Illuminate\Support\Facades\Mail::raw(
                        "Hi {$reservation->name}, your reservation is confirmed. Reference: {$reservation->id}",
                        function ($msg) use ($reservation) {
                            $msg->to($reservation->email)
                                ->subject('Reservation Confirmation - So Hu Beach Club');
                        }
                    );
                }
            } catch (\Throwable $e) {
                Log::error('Reservation email failed: '.$e->getMessage());
            }

            $successMsg = 'Your booking was successful! Please check your email for confirmation.';

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => $successMsg]);
            }

            return redirect()->route('availability', [
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date
            ])->with('success', $successMsg);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => ['server' => [$e->getMessage()]]], 500);
            }
            throw $e;
        }
    }

    /**
     * Mark a reservation as completed.
     */
    public function complete(Reservation $reservation)
    {
        $reservation->status = 'completed';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation marked as completed.');
    }

    /**
     * Display a listing of the bookings.
     */
    public function bookings(Request $request)
    {
        $query = \App\Models\Reservation::with('room')->orderBy('created_at', 'desc');

        // Filter by date if provided
        if ($request->filled('filter_date')) {
            $query->whereDate('created_at', $request->filter_date);
        }

        // Search by guest name, room name, email, or contact if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%")
                  ->orWhereHas('room', function($qr) use ($search) {
                      $qr->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->get();

        return view('admin.bookings', compact('bookings'));
    }
}
