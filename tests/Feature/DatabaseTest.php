<?php

use App\Models\User;

use App\Models\Product;
use function Pest\Laravel\post;
use function Pest\Laravel\putJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;

it('should be able to create a product', function () {

    postJson(route('products.store'), [
        'title' => 'Título do produto',
        'owner_id' => User::factory()->create()->id,
    ])->assertCreated();

    assertDatabaseHas('products', ['title' => 'Título do produto']);

    assertDatabaseCount('products', 1);

    assertTrue(Product::query()->where(['title' => 'Título do produto'])->exists());
});

it('should be able to update a product', function () {
    $product = Product::factory()->create(['title' => 'Título do produto']);

    putJson(route('products.update', $product), [
        'title' => 'Título do produto atualizado',
    ])->assertOk();

    assertDatabaseHas('products', [
        'id' => $product->id,
        'title' => 'Título do produto atualizado'
    ]);

    expect($product)
        ->refresh()
        ->title->toBe('Título do produto atualizado');

    assertSame('Título do produto atualizado', $product->title);

    assertDatabaseCount('products', 1);
});

it('should be able to delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.destroy', $product))
        ->assertOk();

    assertDatabaseMissing('products', [
        'id' => $product->id,
        'title' => $product->title,
    ]);

    assertDatabaseCount('products', 0);
});

it('should be able to soft delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.soft-delete', $product))
        ->assertOk();

    assertSoftDeleted('products', [
        'id' => $product->id,
        'title' => $product->title,
    ]);
});
