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

class CareerInterviewInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public CareerApplication $application;
    public string $emailSubject;
    public string $emailBody;
    public ?string $interviewDate;
    public ?string $interviewTime;
    public ?string $interviewLocation;

    public function __construct(
        CareerApplication $application,
        string $emailSubject,
        string $emailBody,
        ?string $interviewDate = null,
        ?string $interviewTime = null,
        ?string $interviewLocation = null
    ) {
        $this->application = $application;
        $this->emailSubject = $emailSubject;
        $this->emailBody = $emailBody;
        $this->interviewDate = $interviewDate;
        $this->interviewTime = $interviewTime;
        $this->interviewLocation = $interviewLocation;
    }

    public function envelope(): Envelope
    {
        $siteName = config('mail.from.name') ?: Setting::get('site_name', 'Adonis Chemical Limited');
        $fromAddress = config('mail.from.address') ?: Setting::get('contact_email', 'info@acil.com.bd');

        return new Envelope(
            subject: $this->emailSubject,
            from: new Address($fromAddress, $siteName . ' HR Recruitment Desk'),
            replyTo: [
                new Address($fromAddress, $siteName . ' Recruitment Desk')
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.career_interview_invitation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
