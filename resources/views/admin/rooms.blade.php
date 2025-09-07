@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <!-- Back button -->
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <h2 class="mb-4 text-center">Manage Rooms & Availability</h2>
    <div class="card shadow bg-white bg-opacity-75">
        <div class="card-body">
            @php
                $rooms = \App\Models\Room::with(['reservations' => function($q) {
                    $q->orderBy('check_in_date', 'desc');
                }])->get();
            @endphp
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Current Reservations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->description }}</td>
                            <td>₱{{ number_format($room->price, 2) }}</td>
                            <td>
                                @php
                                    $activeReservations = $room->reservations->where('status', 'active');
                                @endphp
                                @if($activeReservations->count())
                                    @foreach($activeReservations as $reservation)
                                        <div class="mb-2 p-2 border rounded">
                                            <div>
                                                <strong>Guest:</strong> {{ $reservation->name }}<br>
                                                <strong>Check-in:</strong> {{ $reservation->check_in_date }}<br>
                                                <strong>Check-out:</strong> {{ $reservation->check_out_date }}<br>
                                                <strong>Status:</strong>
                                                <form method="POST" action="{{ url('/admin/reservations/'.$reservation->id.'/complete') }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-success btn-sm">Mark as Completed</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No rooms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
