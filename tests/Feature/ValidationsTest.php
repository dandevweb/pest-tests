<?php

use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

test('product :: title should be required', function () {
    postJson(route('products.store'), [
        'title' => '',
    ])->assertInvalid(['title' => 'required']);

    post(route('products.store'), [
        'title' => '',
    ])->assertInvalid(['title' => 'required']);
});


test('product :: title should have a max of 255 characters', function () {
    postJson(route('products.store'), [
        'title' => str_repeat('*', 256),
    ])->assertInvalid(['title' => trans(
        'validation.max.string',
        ['attribute' => 'title', 'max' => 255]
    )]);

    post(route('products.store'), [
        'title' => str_repeat('*', 256),
    ])->assertInvalid(['title' => trans(
        'validation.max.string',
        ['attribute' => 'title', 'max' => 255]
    )]);
});


test('create product validations', function ($data, $error) {
    postJson(route('products.store'), $data)
        ->assertInvalid($error);
})->with([
    'title:required' => [['title' => ''], ['title' => 'required']],
    'title:max:255' => [['title' => str_repeat('*', 256)], ['title' => 'The title field must not be greater than 255 characters.']],
]);
