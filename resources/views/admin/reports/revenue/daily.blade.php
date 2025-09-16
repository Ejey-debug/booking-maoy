<!-- filepath: c:\maoy\booking-maoy\resources\views\admin\reports\revenue\daily.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Daily Revenue Summary</h2>
    <div class="card shadow">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3 align-items-end">
                <div class="col-auto">
                    <label for="date" class="form-label mb-0">Select Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Show
                    </button>
                </div>
            </form>
            @php
                $date = request('date', \Carbon\Carbon::today()->format('Y-m-d'));
                $reservations = \App\Models\Reservation::whereDate('created_at', $date)->get();
                $totalRevenue = $reservations->sum('total_price');
            @endphp
            <div class="mb-3">
                <h5 class="fw-bold">Date: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h5>
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
                            <td colspan="7" class="text-center">No bookings found for this date.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<a class="dropdown-item" href="{{ url('/admin/reports/revenue/daily') }}">
    Daily Revenue
</a>
