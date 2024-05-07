<?php

namespace App\Http\ApiV1\Modules\Clients\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class RegisterClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'max:20'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:clients'],
            'email' => ['required', 'string', 'max:30', 'unique:clients'],
            'fio' => ['required', 'string', 'max:100'],
        ];
    }
}
