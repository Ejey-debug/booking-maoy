<!-- filepath: c:\maoy\booking-maoy\resources\views\admin\reports\revenue\monthly.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Monthly Revenue Summary</h2>
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('admin.reports.revenue.monthly.export', ['month' => request('month')]) }}" class="btn btn-outline-success me-2">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
        </a>
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
                    ->orderBy('created_at', 'desc')
                    ->get();

                $addonPrices = [
                    'Jetski Rental' => 5000,
                    'Atv' => 1000,
                ];

                // safer calculation
                $totalRevenue = 0;
                $totalAddons = 0;
                $totalRoom = 0;

                foreach ($reservations as $res) {
                    // parse addons (handle string or array)
                    $addons = $res->addons ?? [];
                    if (is_string($addons)) {
                        $addons = json_decode($addons, true) ?: [];
                    }
                    $addons = is_array($addons) ? $addons : [];

                    $addonsTotal = 0;
                    foreach ($addons as $a) {
                        if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                    }

                    // compute room*nights
                    $roomPrice = optional($res->room)->price ?? 0;
                    try {
                        $nights = \Carbon\Carbon::parse($res->check_out_date)->diffInDays(\Carbon\Carbon::parse($res->check_in_date));
                        if ($nights < 1) $nights = 1;
                    } catch (\Exception $e) {
                        $nights = 1;
                    }
                    $computedRoomTotal = $roomPrice * $nights;

                    // determine reservation total: prefer stored total_price if present (assumed full),
                    // otherwise compute from room+nights + addons
                    if (!is_null($res->total_price)) {
                        $reservationTotal = (float)$res->total_price;
                    } else {
                        $reservationTotal = $computedRoomTotal + $addonsTotal;
                    }

                    // accumulate
                    $totalRevenue += $reservationTotal;
                    $totalAddons += $addonsTotal;
                    $totalRoom += $computedRoomTotal;
                }
            @endphp
            <div class="mb-3">
                <h5 class="fw-bold">Month: {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
                <p>Total Revenue: <span class="fw-bold text-success">₱{{ number_format($totalRevenue, 2) }}</span></p>
                <div class="small text-muted">
                    <div>Room subtotal : ₱{{ number_format($totalRoom,2) }}</div>
                    <div>Add-ons subtotal : ₱{{ number_format($totalAddons,2) }}</div>
                </div>
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
                            <td>{{ optional($reservation->room)->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->check_in_date }}</td>
                            <td>{{ $reservation->check_out_date }}</td>
                            @php
                                // parse addons (handle both array and JSON string) and compute addon totals
                                $addons = $reservation->addons ?? [];
                                if (is_string($addons)) {
                                    $addons = json_decode($addons, true) ?: [];
                                }
                                $addons = is_array($addons) ? $addons : [];

                                $addonsTotal = 0;
                                foreach ($addons as $a) {
                                    if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                                }

                                if (!is_null($reservation->total_price)) {
                                    $displayTotal = (float) $reservation->total_price;
                                } else {
                                    $roomPrice = optional($reservation->room)->price ?? 0;
                                    try {
                                        $nights = \Carbon\Carbon::parse($reservation->check_out_date)->diffInDays(\Carbon\Carbon::parse($reservation->check_in_date));
                                        if ($nights < 1) $nights = 1;
                                    } catch (\Exception $e) {
                                        $nights = 1;
                                    }
                                    $displayTotal = ($roomPrice * $nights) + $addonsTotal;
                                }
                            @endphp
                            <td>
                                ₱{{ number_format($displayTotal, 2) }}
                                @if(!empty($addons))
                                    <div><small class="text-muted">Add-ons: {{ implode(', ', $addons) }} (₱{{ number_format($addonsTotal, 2) }})</small></div>
                                @endif
                            </td>
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
