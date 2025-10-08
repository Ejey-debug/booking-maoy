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
                    // Add-on prices (same as controller)
                    $addonPrices = [
                        'Jetski Rental' => 5000,
                        'Atv' => 1000,
                    ];
                    // Sum using total_price when present, otherwise compute from room price * nights + addons
                    $totalRevenue = $reservations->reduce(function($carry, $res) use ($addonPrices) {
                        $price = 0;
                        // compute addons total
                        $addons = json_decode($res->addons ?? '[]', true) ?: [];
                        $addonsTotal = 0;
                        foreach ($addons as $a) {
                            if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                        }

                        if (!is_null($res->total_price)) {
                            $price = (float) $res->total_price;
                        } else {
                            $roomPrice = optional($res->room)->price ?? 0;
                            try {
                                $nights = \Carbon\Carbon::parse($res->check_out_date)->diffInDays(\Carbon\Carbon::parse($res->check_in_date));
                                if ($nights < 1) $nights = 1;
                            } catch (Exception $e) {
                                $nights = 1;
                            }
                            $price = ($roomPrice * $nights) + $addonsTotal;
                        }
                        return $carry + $price;
                    }, 0);
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
                            @php
                                // parse addons and compute addon totals
                                $addons = json_decode($reservation->addons ?? '[]', true) ?: [];
                                $addonsTotal = 0;
                                foreach ($addons as $a) {
                                    if (isset($addonPrices[$a])) $addonsTotal += $addonPrices[$a];
                                }

                                if (!is_null($reservation->total_price)) {
                                    $displayTotal = (float) $reservation->total_price;
                                    $note = '';
                                } else {
                                    $roomPrice = optional($reservation->room)->price ?? 0;
                                    try {
                                        $nights = \Carbon\Carbon::parse($reservation->check_out_date)->diffInDays(\Carbon\Carbon::parse($reservation->check_in_date));
                                        if ($nights < 1) $nights = 1;
                                    } catch (Exception $e) {
                                        $nights = 1;
                                    }
                                    $displayTotal = ($roomPrice * $nights) + $addonsTotal;
                                    $note = ' <small class="text-muted">(computed)</small>';
                                }
                            @endphp
                            <td>
                                ₱{{ number_format($displayTotal, 2) }}{!! $note !!}
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
