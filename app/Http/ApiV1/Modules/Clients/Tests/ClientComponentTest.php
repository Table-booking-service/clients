<?php

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

test('POST /api/v1/clients/register 201', function () {
    postJson('/api/v1/clients/register')
        ->assertStatus(201);
});

test('POST /api/v1/clients/register 400', function () {
    postJson('/api/v1/clients/register')
        ->assertStatus(400);
});

test('POST /api/v1/clients 201', function () {
    postJson('/api/v1/clients')
        ->assertStatus(201);
});

test('POST /api/v1/clients 400', function () {
    postJson('/api/v1/clients')
        ->assertStatus(400);
});

test('POST /api/v1/clients/login 201', function () {
    postJson('/api/v1/clients/login')
        ->assertStatus(201);
});

test('POST /api/v1/clients/login 400', function () {
    postJson('/api/v1/clients/login')
        ->assertStatus(400);
});

test('GET /api/v1/clients/{id} 200', function () {
    getJson('/api/v1/clients/{id}')
        ->assertStatus(200);
});

test('GET /api/v1/clients/{id} 404', function () {
    getJson('/api/v1/clients/{id}')
        ->assertStatus(404);
});

test('PUT /api/v1/clients/replace/{id} 201', function () {
    putJson('/api/v1/clients/replace/{id}')
        ->assertStatus(201);
});

test('PUT /api/v1/clients/replace/{id} 400', function () {
    putJson('/api/v1/clients/replace/{id}')
        ->assertStatus(400);
});

test('DELETE /api/v1/clients/delete/{id} 200', function () {
    deleteJson('/api/v1/clients/delete/{id}')
        ->assertStatus(200);
});

test('DELETE /api/v1/clients/delete/{id} 404', function () {
    deleteJson('/api/v1/clients/delete/{id}')
        ->assertStatus(404);
});
