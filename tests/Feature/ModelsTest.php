<?php

use App\Models\User;
use App\Models\Product;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    expect($product->owner)
        ->toBeInstanceOf(User::class);
});
