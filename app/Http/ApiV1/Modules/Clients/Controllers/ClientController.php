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
use Illuminate\Support\Facades\Auth;

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

        return new ClientResource($client);
    }

    public function create(CreateClientRequest $request): ClientResource
    {
        $phone = $request->get('phone_number');
        $fio = $request->get('fio');

        $client = new Clients();
        $client->fio = $fio;
        $client->phone_number = $phone;
        $client->save();

        return new ClientResource($client);
    }

    public function login(LoginClientRequest $request): ClientResource
    {
        $validate = $request->validated();

        $client = Clients::query()->where('email', $validate['email'])
            ->where('password', $validate['password'])
            ->first();


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
        $client = Clients::query()->findOrFail($id);

        $phone = $request->get('phone_number');
        $fio = $request->get('fio');
        $email = $request->get('email');
        $password = $request->get('password');

        $client->fio = $fio;
        $client->phone_number = $phone;
        $client->email = $email;
        $client->password = $password;
        $client->save();

        return new ClientResource($client);
    }

    public function delete(int $id): DeleteResource
    {
        $client = Clients::query()->findOrFail($id);
        $client->delete();

        return new DeleteResource($client);
    }
}
