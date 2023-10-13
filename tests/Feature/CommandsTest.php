<?php

use App\Models\User;
use App\Models\Product;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseHas;
use App\Console\Commands\CreateProductCommand;
use function Pest\Laravel\assertDatabaseCount;

it('should be able to create product via command', function () {
    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [
        'title' => 'Product 1',
        'user' => $user->id,
    ])->assertSuccessful();

    assertDatabaseHas(Product::class, [
        'title' => 'Product 1',
        'owner_id' => $user->id,
    ]);

    assertDatabaseCount(Product::class, 1);
});

it('should asks for user and title if is not passed as argument', function () {
    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])
        ->expectsQuestion('What is the user id?', $user->id)
        ->expectsQuestion('What is the title?', 'Product 1')
        ->expectsOutputToContain('Product created!')
        ->assertSuccessful();
});
