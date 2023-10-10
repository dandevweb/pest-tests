<?php

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    expect($product->owner)
        ->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should always ne str()->title', function () {
    $product = Product::factory()->create(['title' => 'my product']);

    expect($product->title)
        ->toBe('My product');
});

test('model set mutator :: product code should be encrypted', function () {
    $product = Product::factory()->create(['code' => 'my product']);

    assertTrue(Hash::isHashed($product->code));
});
