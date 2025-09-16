<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dailyRevenue(Request $request)
    {
        $date = $request->query('date', Carbon::today()->format('Y-m-d'));
        $reservations = Reservation::whereDate('created_at', $date)->with('room')->get();
        $totalRevenue = $reservations->sum('total_price'); // Change to your actual price field

        return view('admin.reports.revenue.daily', compact('reservations', 'date', 'totalRevenue'));
    }
    public function monthlyRevenue(Request $request)
    {
        $month = $request->query('month', \Carbon\Carbon::now()->format('Y-m'));
        $reservations = \App\Models\Reservation::whereYear('created_at', \Carbon\Carbon::parse($month)->year)
            ->whereMonth('created_at', \Carbon\Carbon::parse($month)->month)
            ->with('room')
            ->get();
        $totalRevenue = $reservations->sum('total_price'); // Change to your actual price field

        return view('admin.reports.revenue.monthly', compact('reservations', 'month', 'totalRevenue'));
    }
}
