<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $correo;
    public $asunto;
    public $mensaje;
    public $idPedido;

    public function __construct(array $data)
    {
        $this->correo = $data['correo'];
        $this->asunto = $data['asunto'];
        $this->mensaje = $data['mensaje'];
        $this->idPedido = $data['idPedido'] ?? null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Golstyle - ' . $this->asunto,
            replyTo: [ $this->correo ], 
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contacto',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}