<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductNotification;

it('should sends a notification about a new products', function () {
    Notification::fake();
    $user = User::factory()->create();

    actingAs($user);

    postJson(route('products.store'), [
        'title' => 'Product 1',
    ])->assertCreated();

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductNotification::class);
});
