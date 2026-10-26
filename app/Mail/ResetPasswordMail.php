<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $resetUrl;

    public int $expireMinutes;

    public function __construct(
        User $user,
        #[\SensitiveParameter] string $token,
    ) {
        $this->resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ], false));

        $this->expireMinutes = (int) config(
            'auth.passwords.'.config('auth.defaults.passwords').'.expire'
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Reset your password'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reset-password',
        );
    }
}
