<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

/*
| Public Routes
*/
Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services');
Route::view('/accommodations', 'pages.accommodations')->name('accommodations');
Route::view('/contact', 'pages.contact')->name('contact');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
| Reservation & Availability
*/
Route::get('/reserve', [ReservationController::class, 'create'])->name('reserve.create');
Route::post('/reserve', [ReservationController::class, 'store'])->name('reserve');
Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability');
Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');

/*
| Admin Routes
*/
Route::prefix('admin')->group(function () {
    // Dashboard & Auth
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/login', 'admin.login')->name('admin.login');

    Route::get('/logout', function () {
        Session::flush(); // Clear all session data
        return redirect()->route('admin.login');
    })->name('admin.logout');

    // Reservations
    Route::view('/reservations', 'admin.reservations')->name('admin.reservations');
    Route::patch('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])
        ->name('admin.reservations.complete');

    // Rooms
    Route::view('/rooms', 'admin.rooms')->name('admin.rooms');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');

    // Bookings
    Route::get('/bookings', [ReservationController::class, 'bookings'])->name('admin.bookings');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');

    // Reports
    Route::get('/reports/revenue/daily', [ReportController::class, 'dailyRevenue'])->name('admin.reports.revenue.daily');
    Route::get('/reports/revenue/monthly', [ReportController::class, 'monthlyRevenue'])->name('admin.reports.revenue.monthly');
    Route::get('/reports/top-rooms', function () {
        return view('admin.reports.top-rooms');
    })->name('admin.reports.top-rooms');

    Route::get('/reports/revenue/daily/export', function (Request $request) {
        $date = $request->query('date', Carbon::today()->format('Y-m-d'));
        $reservations = Reservation::whereDate('created_at', $date)->with('room')->get();

        $addonPrices = [
            'Jetski Rental' => 5000,
            'Atv' => 1000,
        ];

        $callback = function () use ($reservations, $addonPrices) {
            $out = fopen('php://output', 'w');
            // header row
            fputcsv($out, ['Date','Room','Booked By','Check-in','Check-out','Add-ons','Total Price','Booked At']);

            foreach ($reservations as $res) {
                // parse addons (handle array or JSON string)
                $addons = $res->addons ?? [];
                if (is_string($addons)) {
                    $addons = json_decode($addons, true) ?: [];
                }
                $addons = is_array($addons) ? $addons : [];

                $addonsTotal = 0;
                foreach ($addons as $a) {
                    if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                }

                $roomPrice = optional($res->room)->price ?? 0;
                try {
                    $nights = Carbon::parse($res->check_out_date)->diffInDays(Carbon::parse($res->check_in_date));
                    if ($nights < 1) $nights = 1;
                } catch (\Exception $e) {
                    $nights = 1;
                }

                if (!is_null($res->total_price)) {
                    $displayTotal = (float) $res->total_price;
                } else {
                    $displayTotal = ($roomPrice * $nights) + $addonsTotal;
                }

                fputcsv($out, [
                    Carbon::parse($res->created_at)->format('Y-m-d'),
                    $res->room->name ?? 'N/A',
                    $res->name ?? 'N/A',
                    $res->check_in_date,
                    $res->check_out_date,
                    implode(', ', $addons),
                    number_format($displayTotal, 2),
                    $res->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($out);
        };

        $filename = "daily_revenue_{$date}.csv";
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    })->name('admin.reports.revenue.daily.export');

    Route::get('/reports/revenue/monthly/export', function (Request $request) {
        $month = $request->query('month', Carbon::now()->format('Y-m'));
        $year = Carbon::parse($month)->year;
        $monthNum = Carbon::parse($month)->month;

        $reservations = Reservation::whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('room')
            ->get();

        $addonPrices = [
            'Jetski Rental' => 5000,
            'Atv' => 1000,
        ];

        $callback = function () use ($reservations, $addonPrices) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Month','Room','Booked By','Check-in','Check-out','Add-ons','Total Price','Booked At']);

            foreach ($reservations as $res) {
                $addons = $res->addons ?? [];
                if (is_string($addons)) $addons = json_decode($addons, true) ?: [];
                $addons = is_array($addons) ? $addons : [];

                $addonsTotal = 0;
                foreach ($addons as $a) {
                    if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                }

                $roomPrice = optional($res->room)->price ?? 0;
                try {
                    $nights = Carbon::parse($res->check_out_date)->diffInDays(Carbon::parse($res->check_in_date));
                    if ($nights < 1) $nights = 1;
                } catch (\Exception $e) {
                    $nights = 1;
                }

                if (!is_null($res->total_price)) {
                    $displayTotal = (float) $res->total_price;
                } else {
                    $displayTotal = ($roomPrice * $nights) + $addonsTotal;
                }

                fputcsv($out, [
                    Carbon::parse($res->created_at)->format('Y-m'),
                    $res->room->name ?? 'N/A',
                    $res->name ?? 'N/A',
                    $res->check_in_date,
                    $res->check_out_date,
                    implode(', ', $addons),
                    number_format($displayTotal, 2),
                    $res->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($out);
        };

        $filename = "monthly_revenue_{$month}.csv";
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    })->name('admin.reports.revenue.monthly.export');
});
