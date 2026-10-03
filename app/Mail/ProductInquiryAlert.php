<?php

namespace App\Mail;

use App\Models\ProductInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductInquiryAlert extends Mailable
{
    use Queueable, SerializesModels;

    public ProductInquiry $inquiry;

    public function __construct(ProductInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function envelope(): Envelope
    {
        $productTitle = $this->inquiry->product ? $this->inquiry->product->name : ($this->inquiry->product_name ?: 'General Commercial Inquiry');
        
        return new Envelope(
            subject: "🔔 New Product Inquiry: [{$productTitle}] from {$this->inquiry->name}",
            replyTo: [
                new Address($this->inquiry->email, $this->inquiry->name)
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry_alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
