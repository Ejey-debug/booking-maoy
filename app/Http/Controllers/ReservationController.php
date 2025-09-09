<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
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
            'nights'         => 'required|integer|min:1',
            'payment_proof'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Validate and create reservation
        $reservation = Reservation::create($validated);

        // Send confirmation email to user
        Mail::raw(
            "Hi {$reservation->name},\n\nThank you for booking at So Hu Beach Club Resort! Your reservation has been received. We will contact you soon for confirmation.\n\nBest regards,\nSo Hu Beach Club Resort Team",
            function ($message) use ($reservation) {
                $message->to($reservation->email)
                        ->subject('Booking Confirmation');
            }
        );

        return redirect()->back()->with('success', 'Your booking was successful! Please check your email for confirmation.');
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
}
