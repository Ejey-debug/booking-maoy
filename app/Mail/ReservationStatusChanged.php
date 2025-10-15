<?php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    public function __construct(Reservation $reservation, string $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function build()
    {
        $subject = strtoupper(substr($this->status,0,1)) . substr($this->status,1) . ' - Reservation #' . $this->reservation->id;
        return $this->subject($subject)
                    ->view('emails.reservation_status_changed')
                    ->with([
                        'reservation' => $this->reservation,
                        'status' => $this->status,
                    ]);
    }
}