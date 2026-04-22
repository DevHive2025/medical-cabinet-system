<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelRdvMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Déclarer la variable en PUBLIC pour y accéder dans le fichier Blade (HTML)
    public $rdv;

    /**
     * Create a new message instance.
     */
    public function __construct(RendezVous $rdv)
    {
        // 2. On assigne le rendez-vous reçu à notre variable
        $this->rdv = $rdv;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // 3. Le sujet de l'email
        return new Envelope(
            subject: 'Rappel : Votre rendez-vous est pour demain',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // 4. Le fichier Blade qui contient le design de l'email
        return new Content(
            view: 'emails.rappel', 
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}