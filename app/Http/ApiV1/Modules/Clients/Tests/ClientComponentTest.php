<?php

use App\Domain\Clients\Models\Clients;
use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

test('POST /api/v1/clients/register 201', function () {
    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-985-156-4582',
        'email' => 'email@email',
        'password' => 'password',
    ];
    postJson('/api/v1/clients/register', $request)
        ->assertStatus(201)
        ->assertJsonPath('data.fio', $request['fio'])
        ->assertJsonPath('data.phone_number', $request['phone_number']);

    assertDatabaseHas(Clients::class, [
        'fio' => $request['fio'],
        'phone_number' => $request['phone_number'],
        'email' => $request['email'],
        'password' => $request['password'],
    ]);
});

test('POST /api/v1/clients/register 400', function () {
    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-985-156-45820000000000000000000000000000000000',
        'email' => 'email@email',
        'password' => 'password',
    ];
    postJson('/api/v1/clients/register', $request)
        ->assertStatus(400);
});

test('POST /api/v1/clients/create 201', function () {
    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-000-156-4259',
    ];

    postJson('/api/v1/clients/create', $request)
        ->assertStatus(201)
        ->assertJsonPath('data.fio', $request['fio'])
        ->assertJsonPath('data.phone_number', $request['phone_number']);

    assertDatabaseHas(Clients::class, [
        'phone_number' => $request['phone_number'],
    ]);
});

test('POST /api/v1/clients/create 400', function () {
    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-985-156-4582dddddddddddddddddddddddddddddddd',
    ];
    postJson('/api/v1/clients/create', $request)
        ->assertStatus(400);
});

test('POST /api/v1/clients/login 200', function () {
    $client = Clients::factory()->create();
    $request = [
        'email' => $client->email,
        'password' => $client->password,
    ];
    postJson("/api/v1/clients/login", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.fio', $client->fio)
        ->assertJsonPath('data.phone_number', $client->phone_number);
});

test('POST /api/v1/clients/login 400', function () {
    $request = [
        'email' => 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
        'password' => 'fffffff',
    ];
    postJson('/api/v1/clients/login', $request)
        ->assertStatus(400);
});

test('GET /api/v1/clients/{id} 200', function () {
    $client = Clients::factory()->create();

    getJson("/api/v1/clients/{$client->id}")
        ->assertStatus(200)
        ->assertJsonPath('data.fio', $client->fio)
        ->assertJsonPath('data.phone_number', $client->phone_number);
});

test('GET /api/v1/clients/{id} 404', function () {
    getJson('/api/v1/clients/1111')
        ->assertStatus(404);
});

test('GET /api/v1/clients 200', function () {
    getJson("/api/v1/clients")
        ->assertStatus(200);
});

test('PUT /api/v1/clients/replace/{id} 201', function () {
    $client = Clients::factory()->create();

    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-985-156-4582',
        'email' => 'email@email',
        'password' => 'password',
    ];
    putJson("/api/v1/clients/replace/{$client->id}", $request)
        ->assertStatus(200)
        ->assertJsonPath('data.fio', $request['fio'])
        ->assertJsonPath('data.phone_number', $request['phone_number']);

    assertDatabaseHas(Clients::class, [
        'fio' => $request['fio'],
        'phone_number' => $request['phone_number'],
        'email' => $request['email'],
        'password' => $request['password'],
    ]);
});

test('PUT /api/v1/clients/replace/{id} 404', function () {
    $request = [
        'fio' => 'Гусев Денис Александрович',
        'phone_number' => '+7-985-156-4582',
        'email' => 'email@email',
        'password' => 'password',
    ];
    putJson('/api/v1/clients/replace/4569', $request)
        ->assertStatus(404);
});

test('DELETE /api/v1/clients/delete/{id} 200', function () {
    $client = Clients::factory()->create();
    deleteJson("/api/v1/clients/delete/{$client->id}")
        ->assertStatus(200);
    assertDatabaseMissing(Clients::class, ['id' => $client->id]);
});

test('DELETE /api/v1/clients/delete/{id} 404', function () {
    deleteJson('/api/v1/clients/delete/4596')
        ->assertStatus(404);
});
