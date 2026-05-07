<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $url;

    public function __construct($usuario, $url)
    {
        $this->usuario = $usuario;
        $this->url = $url;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirma tu correo en GolStyle'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verificacion'
        );
    }
}