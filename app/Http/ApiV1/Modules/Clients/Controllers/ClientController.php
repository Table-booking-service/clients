<?php

namespace App\Http\ApiV1\Modules\Clients\Controllers;

use App\Domain\Clients\Models\Clients;
use App\Http\ApiV1\Modules\Clients\Requests\CreateClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\LoginClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\PutClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\RegisterClientRequest;
use App\Http\ApiV1\Modules\Clients\Resources\ClientResource;
use App\Http\ApiV1\Modules\Clients\Resources\ClientsResource;
use App\Http\ApiV1\Modules\Clients\Resources\DeleteResource;

class ClientController
{
    public function register(RegisterClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = new Clients();
        $client->fio = $validate['fio'];
        $client->email = $validate['email'];
        $client->phone_number = $validate['phone_number'];
        $client->password = $validate['password'];
        $client->save();

        $ivlen = openssl_cipher_iv_length(env('X_API_SECRET_ALGORITHM'));
        $iv = openssl_random_pseudo_bytes($ivlen);
        $token = openssl_encrypt(strval($client->id), env('X_API_SECRET_ALGORITHM'), env('X_API_SECRET_KEY'), 0, $iv);
        setcookie('token', $token);

        return new ClientResource($client);
    }

    public function create(CreateClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = new Clients();
        $client->fio = $validate['fio'];
        $client->phone_number = $validate['phone_number'];
        $client->save();

        return new ClientResource($client);
    }

    public function login(LoginClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = Clients::query()->where('email', $validate['email'])
            ->where('password', $validate['password'])
            ->first();

        if (!$client) {
            abort(404, 'No client with that email or password');
        }

        $ivlen = openssl_cipher_iv_length('aes-128-cbc');
        $iv = openssl_random_pseudo_bytes($ivlen);
        $token = openssl_encrypt(strval($client->id), 'aes-128-cbc', 'bloodshed', 0, $iv);
        setcookie('token', $token);

        return new ClientResource($client);
    }

    public function get(int $id): ClientResource
    {
        $client = Clients::query()->findOrFail($id);

        return new ClientResource($client);
    }

    public function get_clients(): ClientsResource
    {
        $clients = Clients::query()->get();

        if ($clients->isEmpty()) {
            abort(404, 'No clients.');
        }

        return new ClientsResource($clients);
    }

    public function replace(int $id, PutClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = Clients::query()->findOrFail($id);

        $client->fio = $validate['fio'];
        $client->phone_number = $validate['phone_number'];
        $client->email = $validate['email'];
        $client->password = $validate['password'];
        $client->save();

        return new ClientResource($client);
    }

    public function delete(int $id): DeleteResource
    {
        $client = Clients::query()->findOrFail($id);
        $client->delete();

        return new DeleteResource($client);
    }

    public function logout(): DeleteResource
    {
        setcookie('token', '', time() - 3600);

        return new DeleteResource('');
    }
}
