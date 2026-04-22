<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationRdvMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rdv;
    public $urlConfirmation;

    public function __construct($rdv, $urlConfirmation)
    {
        $this->rdv = $rdv;
        $this->urlConfirmation = $urlConfirmation;
    }

    public function build()
    {
        return $this->subject('Confirmez votre rendez-vous médical')
                    ->view('emails.confirmation_rdv');
    }
}
