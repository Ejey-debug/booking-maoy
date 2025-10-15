<?php
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Reservation Status</title></head>
<body>
    <h2>Reservation {{ strtoupper($status) }}</h2>

    <p>Hi {{ $reservation->name }},</p>

    <p>Your reservation (ID: <strong>#{{ $reservation->id }}</strong>) has been <strong>{{ $status }}</strong>.</p>

    @php
        use Carbon\Carbon;
        $ci = $reservation->check_in_date ? Carbon::parse($reservation->check_in_date) : null;
        $co = $reservation->check_out_date ? Carbon::parse($reservation->check_out_date) : null;
    @endphp

    <ul>
        <li>Room: {{ optional($reservation->room)->name ?? 'N/A' }}</li>
        <li>Check-in: {{ $ci ? $ci->format('F j, Y \a\t g:i A') : 'N/A' }}</li>
        <li>Check-out: {{ $co ? $co->format('F j, Y \a\t g:i A') : 'N/A' }}</li>
        <li>Guests: {{ $reservation->guests ?? 'N/A' }}</li>
        <li>Reference: {{ $reservation->reference_number ?? '—' }}</li>
    </ul>

    <p>If you have questions, reply to this email or contact us.</p>
    <p>Regards,<br>So Hu Beach Club Resort</p>
</body>
</html>