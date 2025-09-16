<!-- filepath: c:\maoy\booking-maoy\resources\views\admin\reports\revenue\monthly.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Monthly Revenue Summary</h2>
    <div class="d-flex justify-content-end mb-2">
        <button onclick="printMonthlyRevenue()" class="btn btn-outline-primary">
            <i class="bi bi-printer me-1"></i> Print
        </button>
    </div>
    <div class="card shadow" id="printArea">
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

<!-- Print Script -->
<script>
function printMonthlyRevenue() {
    var printContents = document.getElementById("printArea").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // reload page to restore JS functionality
}
</script>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    button, a, form {
        display: none !important; /* Hide buttons, links, and form */
    }
}
</style>
@endsection
