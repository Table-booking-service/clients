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
use Illuminate\Support\Facades\Log;

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
        setcookie('token', $token, 60);
        Log::channel('stack')->info("Clients Register $client");
        return new ClientResource($client);
    }

    public function create(CreateClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = new Clients();
        $client->fio = $validate['fio'];
        $client->phone_number = $validate['phone_number'];
        $client->save();
        Log::channel('stack')->info("Clients Create $client");
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
        Log::channel('stack')->info("Clients Login $client");
        return new ClientResource($client);
    }

    public function get(int $id): ClientResource
    {
        $client = Clients::query()->findOrFail($id);
        Log::channel('stack')->info("Clients Get $client");
        return new ClientResource($client);
    }

    public function get_clients(): ClientsResource
    {
        $clients = Clients::query()->select('id', 'fio', 'phone_number', 'created_at', 'updated_at')->get();

        if ($clients->isEmpty()) {
            abort(404, 'No clients.');
        }
        Log::channel('stack')->info('Clients Get All');
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
        Log::channel('stack')->info("Clients Replace $client");
        return new ClientResource($client);
    }

    public function delete(int $id): DeleteResource
    {
        $client = Clients::query()->findOrFail($id);
        $client->delete();
        Log::channel('stack')->info("Clients Delete id: {id}", ['id' => $id]);
        return new DeleteResource($client);
    }

    public function logout(): DeleteResource
    {
        setcookie('token', '', time() - 3600);
        Log::channel('stack')->info("Clients Logout");
        return new DeleteResource('');
    }
}
