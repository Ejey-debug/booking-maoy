<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class PaymentController extends Controller
{
    /**
     * Show all proof of payments.
     */
    public function index()
    {
        $reservations = Reservation::whereNotNull('payment_proof')
            ->with('room')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payments.index', compact('reservations'));
    }
}
