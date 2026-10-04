<?php

namespace App\Mail;

use App\Models\CareerApplication;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CareerApplicationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public CareerApplication $application;

    public function __construct(CareerApplication $application)
    {
        $this->application = $application;
    }

    public function envelope(): Envelope
    {
        $jobTitle = $this->application->job ? $this->application->job->title : 'Open Position';
        $siteName = config('mail.from.name') ?: Setting::get('site_name', 'Adonis Chemical Limited');
        $fromAddress = config('mail.from.address') ?: Setting::get('contact_email', 'info@acil.com.bd');

        return new Envelope(
            subject: "Application Received — {$jobTitle} [Ref: {$this->application->reference}]",
            from: new Address($fromAddress, $siteName . ' HR Team'),
            replyTo: [
                new Address($fromAddress, $siteName . ' Recruitment Desk')
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.career_application_confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
