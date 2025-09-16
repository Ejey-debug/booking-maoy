<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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
});
