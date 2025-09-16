@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <!-- Back button -->
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <h2 class="mb-4 text-center">All Reservations</h2>
    <div class="card shadow bg-white bg-opacity-75">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Guests</th>
                        <th>Add-ons</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        use Carbon\Carbon;
                        $reservations = \App\Models\Reservation::with('room')->orderBy('check_in_date', 'desc')->get();
                    @endphp
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->room->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->name }}</td>
                            <td>{{ $reservation->email }}</td>
                            <td>{{ $reservation->contact }}</td>
                            <td>{{ Carbon::parse($reservation->check_in_date)->format('Y-m-d h:i A') }}</td>
                            <td>{{ Carbon::parse($reservation->check_out_date)->format('Y-m-d h:i A') }}</td>
                            <td>{{ $reservation->guests }}</td>
                            <td>
                                @if(!empty($reservation->addons))
                                    @if(is_array($reservation->addons))
                                        {{ implode(', ', $reservation->addons) }}
                                    @else
                                        {{ $reservation->addons }}
                                    @endif
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>{{ $reservation->created_at->format('Y-m-d h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
