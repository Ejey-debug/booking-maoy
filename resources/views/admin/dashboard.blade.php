@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold" style="letter-spacing: 2px;">Admin Dashboard</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 bg-white bg-opacity-75">
                <div class="card-body">
                    <h4 class="mb-4 text-center" style="font-family: 'Great Vibes', cursive; font-size: 2rem; color: #1e88e5;">
                        Welcome, Admin!
                    </h4>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3">
                            <a href="{{ url('/admin/reservations') }}" class="d-flex align-items-center text-decoration-none text-dark fw-semibold">
                                <i class="bi bi-calendar-check me-3 fs-4 text-primary"></i>
                                View All Reservations
                            </a>
                        </li>
                        <li class="list-group-item py-3">
                            <a href="{{ url('/admin/rooms') }}" class="d-flex align-items-center text-decoration-none text-dark fw-semibold">
                                <i class="bi bi-door-closed me-3 fs-4 text-success"></i>
                                Manage Rooms
                            </a>
                        </li>
                        <li class="list-group-item py-3">
                            <a href="{{ url('/admin/payments') }}" class="d-flex align-items-center text-decoration-none text-dark fw-semibold">
                                <i class="bi bi-cash-coin me-3 fs-4 text-warning"></i>
                                Proof of Payments
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
