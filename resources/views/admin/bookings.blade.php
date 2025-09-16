@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
        <!-- 🖨️ Print Button -->
        <button onclick="printBookings()" class="btn btn-primary d-inline-flex align-items-center">
            <i class="bi bi-printer me-2"></i> Print
        </button>
    </div>

    <h2 class="mb-4 fw-bold">Bookings</h2>

    <!-- Filter/Search Form -->
    <form method="GET" action="{{ url('/admin/bookings') }}" class="row g-2 mb-3 align-items-end">
        <div class="col-auto">
            <label for="filter_date" class="form-label mb-0">Filter by Date</label>
            <input type="date" name="filter_date" id="filter_date" class="form-control" value="{{ request('filter_date') }}">
        </div>
        <div class="col-auto">
            <label for="search" class="form-label mb-0">Search</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Guest, Room, Email..." value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search me-1"></i> Search
            </button>
            <a href="{{ url('/admin/bookings') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-body" id="printArea">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Add-ons</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->room->name ?? 'N/A' }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->contact }}</td>
                            <td>
                                @if(!empty($booking->addons))
                                    @if(is_array($booking->addons))
                                        {{ implode(', ', $booking->addons) }}
                                    @else
                                        {{ $booking->addons }}
                                    @endif
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>{{ $booking->created_at->format('Y-m-d h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Script -->
<script>
    function printBookings() {
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
    button, a {
        display: none !important; /* Hide buttons & links */
    }
}
</style>
@endsection
