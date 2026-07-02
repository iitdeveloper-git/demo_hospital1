<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly array $appointment)
    {
    }

    public function build(): self
    {
        return $this->subject('AarogyaCare appointment request received')
            ->view('emails.appointment-confirmation');
    }
}
