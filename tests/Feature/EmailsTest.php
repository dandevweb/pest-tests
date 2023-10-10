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
        fn (WelcomeEmail $mail) => $mail->assertHasTo($user->email)
    );
});

test('an email should contain the user name', function () {
    $user = User::factory()->create();

    $mail = new WelcomeEmail($user);

    expect($mail)
        ->assertHasSubject('Thank you ' . $user->name);
});

test('email content should contain user email with a text', function () {
    $user = User::factory()->create();

    $mail = new WelcomeEmail($user);

    expect($mail)
        ->assertSeeInHtml('Confirmando que o seu e-mail é: ' . $user->email);
});
