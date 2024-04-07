<?php

namespace App\Http\ApiV1\Modules\Clients\Controllers;

use App\Http\ApiV1\Modules\Clients\Requests\CreateClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\LoginClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\PutClientRequest;
use App\Http\ApiV1\Modules\Clients\Requests\RegisterClientRequest;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class ClientController
{
    public function register(RegisterClientRequest $request): Responsable
    {
        //
    }

    public function create(CreateClientRequest $request): Responsable
    {
        //
    }

    public function login(LoginClientRequest $request): Responsable
    {
        //
    }

    public function get(int $id): Responsable
    {
        //
    }

    public function replace(int $id, PutClientRequest $request): Responsable
    {
        //
    }

    public function delete(int $id, Request $request): Responsable
    {
        //
    }
}
