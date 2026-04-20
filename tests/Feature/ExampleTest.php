<?php

test('a guest is redirected from /', function () {
    $response = $this->get('/');
    $response->assertStatus(302); // Redireciona para login
});

test('an authenticated user can access /', function () {
    $user = \Modules\Seguranca\Models\Usuarios::first() ?? \Modules\Seguranca\Models\Usuarios::factory()->create();
    $response = $this->actingAs($user)->get('/');
    $response->assertStatus(200);
});
