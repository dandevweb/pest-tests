<?php

use App\Models\User;
use App\Models\Product;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use App\Actions\CreateProductAction;
use function Pest\Laravel\assertDatabaseHas;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductNotification;
use function Pest\Laravel\assertDatabaseCount;

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


it('should be able to create a product', function () {
    Notification::fake();

    $user = User::factory()->create();

    (new CreateProductAction())->handle('Product 1', $user);

    assertDatabaseCount(Product::class, 1);
    assertDatabaseHas(Product::class, [
        'title' => 'Product 1',
        'owner_id' => $user->id,
    ]);

    Notification::assertSentTo($user, NewProductNotification::class);
});
