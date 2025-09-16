@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <!-- Back button -->
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <h2 class="mb-4 text-center">Proof of Payments</h2>
    <div class="card shadow bg-white bg-opacity-75">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Booked At</th>
                        <th>Proof of Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activeReservations = $reservations->where('status', 'active');
                    @endphp
                    @forelse($activeReservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->room->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->email }}</td>
                            <td>{{ $reservation->contact }}</td>
                            <td>{{ $reservation->created_at->format('Y-m-d h:i A') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $reservation->payment_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $reservation->payment_proof) }}"
                                         alt="Proof of Payment"
                                         style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No active proof of payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
