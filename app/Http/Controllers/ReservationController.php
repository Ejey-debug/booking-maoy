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

        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'contact'        => 'required|string|max:11',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests'         => 'required|integer|min:1',
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
            // Add more add-ons and prices as needed
        ];

        // Calculate add-ons total
        $selectedAddons = $request->input('addons', []);
        $addonsTotal = 0;
        foreach ($selectedAddons as $addon) {
            if (isset($addonPrices[$addon])) {
                $addonsTotal += $addonPrices[$addon];
            }
        }

        // Calculate total price (room price * nights + add-ons)
        $room = Room::find($request->room_id);
        $nights = \Carbon\Carbon::parse($request->check_out_date)->diffInDays(\Carbon\Carbon::parse($request->check_in_date));
        $roomTotal = $room->price * $nights;
        $calculatedTotalPrice = $roomTotal + $addonsTotal;
        $validated['total_price'] = $calculatedTotalPrice;

        // Save selected add-ons as JSON (optional, if you want to store them)
        $validated['addons'] = json_encode($selectedAddons);

        // Create reservation (only once, after total_price is set)
        $reservation = Reservation::create($validated);

        // Create a new user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('defaultpassword'), // or generate a random password
        ]);

        // Send confirmation email to user
        Mail::raw(
            "Hi {$reservation->name},\n\nThank you for booking at So Hu Beach Club Resort! Your reservation has been received. We will contact you soon for confirmation.\n\nBest regards,\nSo Hu Beach Club Resort Team",
            function ($message) use ($reservation) {
                $message->to($reservation->email)
                        ->subject('Booking Confirmation');
            }
        );

        // Redirect to availability page with success message
        return redirect()->route('availability', [
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date
        ])->with('success', 'Your booking was successful! Please check your email for confirmation.');
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
