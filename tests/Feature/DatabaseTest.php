<?php

use App\Models\Product;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertTrue;

it('should be able to create a product', function () {

    postJson(route('products.store'), [
        'title' => 'Título do produto',
    ])->assertCreated();

    assertDatabaseHas('products', ['title' => 'Título do produto']);

    assertDatabaseCount('products', 1);

    assertTrue(Product::query()->where(['title' => 'Título do produto'])->exists());
});

it('should be able to update a product', function () {
})->todo();

it('should be able to delete a product', function () {
})->todo();
