<?php

namespace App\Http\ApiV1\Modules\Clients\Controllers;

use App\Domain\Clients\Models\Clients;
use App\Http\ApiV1\Modules\Clients\Requests\CreateClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\LoginClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\PutClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\RegisterClientRequest;
use App\Http\ApiV1\Modules\Clients\Resources\ClientResource;
use Illuminate\Support\Facades\DB;

class ClientController
{
    public function register(RegisterClientRequest $request): ClientResource
    {
        $client = new Clients();
        $client->fio = $request->get('fio');
        $client->email = $request->get('email');
        $client->phone_number = $request->get('phone_number');
        $client->password = $request->get('password');
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
        $client = Clients::query()->where('email', $request->get('email'))
            ->where('password', $request->get('password'))
            ->first();

        return new ClientResource($client);
    }

    public function get(int $id): ClientResource
    {
        $client = Clients::query()->findOrFail($id);

        return new ClientResource($client);
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

    public function delete(int $id): void
    {
        $client = Clients::query()->findOrFail($id);
        $client->delete();
    }
}
