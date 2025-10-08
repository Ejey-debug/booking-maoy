<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $checkInDate = $request->query('check_in_date');
        $checkOutDate = $request->query('check_out_date');

        $rooms = collect();

        if ($checkInDate && $checkOutDate) {
            $rooms = $this->getAvailableRooms($checkInDate, $checkOutDate);
        }

        return view('pages.availability', [
            'rooms' => $rooms,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'name' => $request->query('name'),
            'email' => $request->query('email'),
            'contact' => $request->query('contact'),
            'guests' => $request->query('guests'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
        ]);

        $rooms = $this->getAvailableRooms($validated['check_in_date'], $validated['check_out_date']);

        return view('pages.availability', [
            'rooms' => $rooms,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'guests' => $validated['guests'],
        ]);
    }

    protected function getAvailableRooms(string $checkInDate, string $checkOutDate)
    {
        return Room::whereDoesntHave('reservations', function ($query) use ($checkInDate, $checkOutDate) {
            $query->where('status', 'active')
                ->where(function ($q) use ($checkInDate, $checkOutDate) {
                    $q->where('check_in_date', '<', $checkOutDate)
                        ->where('check_out_date', '>', $checkInDate);
                });
        })->get();
    }
}
