<?php

namespace App\Http\ApiV1\Modules\Clients\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class CreateClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string', 'max:20', 'unique:clients'],
            'fio' => ['required', 'string', 'max:100'],
        ];
    }
}
