<?php

namespace App\Http\ApiV1\Modules\Clients\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class PutClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['required', 'string'],
            'fio' => ['required', 'string'],
        ];
    }
}
