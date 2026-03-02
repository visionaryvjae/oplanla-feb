<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address; // Import the Address class

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The array of form data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     * @param array $data The validated form data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     * This defines the from, to, cc, bcc, and subject.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Set the "from" address using the user's details from the form
            from: new Address($this->data['email'], $this->data['name']),
            replyTo: [
                new Address($this->data['email'], $this->data['name'])
            ],
            subject: 'New Message from Contact Form',
        );
    }

    /**
     * Get the message content definition.
     * This points to the view file for the email's body.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.form', // We will create this view next
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