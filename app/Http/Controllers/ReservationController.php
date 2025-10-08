<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
                'payment_proof'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'addons'         => 'array',
                'addons.*'       => 'string',
            ]);

            // Handle file upload
            if ($request->hasFile('payment_proof')) {
                $validated['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            // Add-on prices (hardcoded)
            $addonPrices = [
                'Jetski Rental' => 5000,
                'Atv' => 1000,
            ];
            $selectedAddons = $request->input('addons', []);
            $addonsTotal = 0;
            foreach ($selectedAddons as $addon) {
                if (isset($addonPrices[$addon])) {
                    $addonsTotal += $addonPrices[$addon];
                }
            }

            // Calculate total price (room price * nights + add-ons)
            $room = \App\Models\Room::find($request->room_id);
            $nights = \Carbon\Carbon::parse($request->check_out_date)->diffInDays(\Carbon\Carbon::parse($request->check_in_date));
            $roomTotal = $room->price * $nights;
            $calculatedTotalPrice = $roomTotal + $addonsTotal;
            $validated['total_price'] = $calculatedTotalPrice;
            $validated['addons'] = json_encode($selectedAddons);

            // Ensure required DB columns have values (hotfix)
            $validated['user_id'] = $validated['user_id'] ?? null;
            $validated['name']    = $validated['name']    ?? 'Guest';
            $validated['email']   = $validated['email']   ?? 'no-email@local';
            $validated['contact'] = $validated['contact'] ?? '0000000000';
            $validated['guests']  = $validated['guests']  ?? 1;

            $reservation = Reservation::create($validated);

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
