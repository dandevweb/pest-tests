<?php

use function Pest\Laravel\get;

test('the application is working')
    ->get('/')
    ->assertSuccessful();