<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;



Route::get('/', function () {
    return view('pages.home');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/services', function () {
    return view('pages.services');
});
Route::get('/accommodations', function () {
    return view('pages.accommodations');
});
Route::get('/contact', function () {
    return view('pages.contact');
});

Route::post('/reserve', [ReservationController::class, 'store']);
Route::get('/reserve', [ReservationController::class, 'create']);
Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability');
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/admin/login', function () {
    return view('admin.login');
});
Route::get('/admin/logout', function () {
    Session::flush(); // Clear all session data
    return redirect('/admin/login');
});
Route::get('/admin/reservations', function () {
    return view('admin.reservations');
});
Route::patch('/admin/reservations/{reservation}/complete', [App\Http\Controllers\ReservationController::class, 'complete']);
Route::get('/admin/rooms', function () {
    return view('admin.rooms');
});
Route::post('/contact/send', [ContactController::class, 'send']);

Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments');
