<?php

use App\Models\User;

use App\Mail\WelcomeEmail;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\Mail;

test('an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class);
});


test('an email was sent to the correct user', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(
        WelcomeEmail::class,
        fn (WelcomeEmail $mail) => $mail->hasTo($user->email)
    );
});
