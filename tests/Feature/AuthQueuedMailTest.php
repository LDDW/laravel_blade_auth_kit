<?php

use App\Mail\ResetPasswordMail;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('queues the email verification mail', function () {
    Mail::fake();

    $user = User::factory()->unverified()->create();

    $user->sendEmailVerificationNotification();

    Mail::assertQueued(VerifyEmailMail::class, fn (VerifyEmailMail $mail) => $mail->hasTo($user->email));
});

it('queues the password reset mail', function () {
    Mail::fake();

    $user = User::factory()->create();

    $user->sendPasswordResetNotification('test-token');

    Mail::assertQueued(ResetPasswordMail::class, fn (ResetPasswordMail $mail) => $mail->hasTo($user->email));
});
