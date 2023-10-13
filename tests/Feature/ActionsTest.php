<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

use function Pest\Laravel\postJson;
use App\Actions\CreateProductAction;
use Illuminate\Support\Facades\Notification;

it('should call the action to create a product', function () {
    Notification::fake();

    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()
        ->once();

    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);

    postJson(route('products.store'), [
        'title' => $title,
    ]);
});
