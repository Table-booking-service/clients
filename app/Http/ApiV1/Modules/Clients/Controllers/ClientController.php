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
        Log::channel('stack')->info("Clients Register");
        $validate = $request->validated();

        $client = new Clients();
        $client->fio = $validate['fio'];
        $client->email = $validate['email'];
        $client->phone_number = $validate['phone_number'];
        $client->password = $validate['password'];
        $client->save();

        $algo = env('X_API_SECRET_ALGORITHM');
        $key = env('X_API_SECRET_KEY');
        $ivlen = openssl_cipher_iv_length($algo);
        $iv = str_repeat('0', $ivlen);
        $token = openssl_encrypt(strval($client->id), $algo, $key, 0, $iv);
        setcookie('token', $token);

        return new ClientResource($client);
    }

    public function create(CreateClientRequest $request): ClientResource
    {
        Log::channel('stack')->info("Clients Create");
        $validate = $request->validated();

        $client = new Clients();
        $client->fio = $validate['fio'];
        $client->phone_number = $validate['phone_number'];
        $client->save();

        return new ClientResource($client);
    }

    public function login(LoginClientRequest $request): ClientResource
    {
        Log::channel('stack')->info("Clients Login");
        $validate = $request->validated();

        $client = Clients::query()->where('email', $validate['email'])
            ->where('password', $validate['password'])
            ->first();

        if (!$client) {
            abort(404, 'No client with that email or password');
        }

        $algo = env('X_API_SECRET_ALGORITHM');
        $key = env('X_API_SECRET_KEY');
        $ivlen = openssl_cipher_iv_length($algo);
        $iv = str_repeat('0', $ivlen);
        $token = openssl_encrypt(strval($client->id), $algo, $key, 0, $iv);
        setcookie('token', $token);

        return new ClientResource($client);
    }

    public function get(int $id): ClientResource
    {
        Log::channel('stack')->info("Clients Get");
        $client = Clients::query()->findOrFail($id);

        return new ClientResource($client);
    }

    public function get_clients(): ClientsResource
    {
        Log::channel('stack')->info("Clients Get All");
        $clients = Clients::query()->select('id', 'fio', 'phone_number', 'created_at', 'updated_at')->get();

        if ($clients->isEmpty()) {
            abort(404, 'No clients.');
        }
        return new ClientsResource($clients);
    }

    public function replace(int $id, PutClientRequest $request): ClientResource
    {
        Log::channel('stack')->info("Clients Replace");
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
        Log::channel('stack')->info("Clients Delete");
        $client = Clients::query()->findOrFail($id);
        $client->delete();
        return new DeleteResource($client);
    }

    public function logout(): DeleteResource
    {
        Log::channel('stack')->info("Clients Logout");
        setcookie('token', '', time() - 3600);

        return new DeleteResource('');
    }
}
