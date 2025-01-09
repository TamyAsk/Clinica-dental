<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $detalle;

    public function __construct($detalle)
    {
        $this->detalle = $detalle;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->detalle['titulo'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.aviso',
            with: ['detalle' => $this->detalle],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
