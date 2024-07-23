<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $sendEmail;

    public function __construct($sendEmail)
    {
        $this->sendEmail = $sendEmail;
        $this->attach($sendEmail['qrCodePath']); // Menyertakan gambar QR code sebagai lampiran
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sendEmail['subject']
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.email'
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
