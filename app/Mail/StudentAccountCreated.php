<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentAccountCreated extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        public User $student,
        public string $password,
        public bool $isPasswordReset = false
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isPasswordReset
            ? 'Your Password Has Been Reset'
            : 'Welcome to Student Portal - Your Account Details';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
     /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student-account-created',
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
