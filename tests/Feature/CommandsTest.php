<?php

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseHas;
use App\Console\Commands\CreateProductCommand;
use function Pest\Laravel\assertDatabaseCount;

it('should be able to create product via command', function () {
    $user = \App\Models\User::factory()->create();

    artisan(CreateProductCommand::class, [
        'title' => 'Product 1',
        'user' => $user->id,
    ])->assertSuccessful();

    assertDatabaseHas(\App\Models\Product::class, [
        'title' => 'Product 1',
        'owner_id' => $user->id,
    ]);

    assertDatabaseCount(\App\Models\Product::class, 1);
});
