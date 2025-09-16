<!-- filepath: c:\maoy\booking-maoy\resources\views\admin\reports\top-rooms.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Top Rooms Booked</h2>
    <div class="card shadow">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3 align-items-end">
                <div class="col-auto">
                    <label for="month" class="form-label mb-0">Select Month</label>
                    <input type="month" name="month" id="month" class="form-control"
                        value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Show
                    </button>
                </div>
            </form>
            @php
                $month = request('month', \Carbon\Carbon::now()->format('Y-m'));
                $topRooms = \App\Models\Room::withCount(['reservations' => function($query) use ($month) {
                        $query->whereYear('created_at', \Carbon\Carbon::parse($month)->year)
                              ->whereMonth('created_at', \Carbon\Carbon::parse($month)->month);
                    }])
                    ->orderBy('reservations_count', 'desc')
                    ->take(10)
                    ->get();
            @endphp
            <h5 class="fw-bold mb-3">Top Rooms Booked for {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room Name</th>
                        <th>Description</th>
                        <th>Times Booked ({{ \Carbon\Carbon::parse($month)->format('F Y') }})</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topRooms as $room)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->description }}</td>
                            <td>{{ $room->reservations_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No room bookings found for this month.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
