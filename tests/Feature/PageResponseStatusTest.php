<?php

test('testando código 200')
    ->get('/')
    ->assertOk();

test('testando código 404')
    ->get('/nao-existe')
    ->assertNotFound();

test('testando o código 403:: não tem permissão de acesso')
    ->get('/403')
    ->assertForbidden();
