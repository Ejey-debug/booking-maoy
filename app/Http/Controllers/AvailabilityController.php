<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $check_in_date = $request->query('check_in_date');
        $check_out_date = $request->query('check_out_date');

        // Example: Get available rooms (replace with your actual logic)
        $rooms = Room::whereDoesntHave('reservations', function($query) use ($check_in_date, $check_out_date) {
            $query->where(function($q) use ($check_in_date, $check_out_date) {
                $q->where('check_in_date', '<', $check_out_date)
                  ->where('check_out_date', '>', $check_in_date);
            });
        })->get();

        return view('pages.availability', compact('rooms', 'check_in_date', 'check_out_date'));
    }
}
