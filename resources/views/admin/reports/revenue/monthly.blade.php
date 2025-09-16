<!-- filepath: c:\maoy\booking-maoy\resources\views\admin\reports\revenue\monthly.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Monthly Revenue Summary</h2>
    <div class="card shadow">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3 align-items-end">
                <div class="col-auto">
                    <label for="month" class="form-label mb-0">Select Month</label>
                    <input type="month" name="month" id="month" class="form-control" value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Show
                    </button>
                </div>
            </form>
            @php
                $month = request('month', \Carbon\Carbon::now()->format('Y-m'));
                $reservations = \App\Models\Reservation::whereYear('created_at', \Carbon\Carbon::parse($month)->year)
                    ->whereMonth('created_at', \Carbon\Carbon::parse($month)->month)
                    ->get();
                $totalRevenue = $reservations->sum('total_price'); // Change to your actual price field
            @endphp
            <div class="mb-3">
                <h5 class="fw-bold">Month: {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
                <p>Total Revenue: <span class="fw-bold text-success">₱{{ number_format($totalRevenue, 2) }}</span></p>
            </div>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room</th>
                        <th>Booked By</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total Price</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->room->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->check_in_date }}</td>
                            <td>{{ $reservation->check_out_date }}</td>
                            <td>₱{{ number_format($reservation->total_price, 2) }}</td>
                            <td>{{ $reservation->created_at->format('Y-m-d h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No bookings found for this month.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
