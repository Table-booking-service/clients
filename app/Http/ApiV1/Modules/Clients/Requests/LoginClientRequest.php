<?php

namespace App\Http\ApiV1\Modules\Clients\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class LoginClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'email' => ['required', 'string'],
        ];
    }
}
