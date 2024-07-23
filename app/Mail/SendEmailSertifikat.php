<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class SendEmailSertifikat extends Mailable
{
    use Queueable, SerializesModels;

    public $sendEmailSertifikat;
    public $documentPath;

    public function __construct($sendEmailSertifikat, $documentPath)
    {
        $this->sendEmailSertifikat = $sendEmailSertifikat;
        $this->documentPath = $documentPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sendEmailSertifikat['subject']
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.sertifikat'
        );
    }

    public function attachments(): array
    {
        return [
            ['path' => storage_path('app/' . $this->documentPath)]
        ];
    }
}
