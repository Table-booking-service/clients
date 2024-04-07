<?php

namespace App\Http\ApiV1\Modules\Clients\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class CreateClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string'],
            'fio' => ['required', 'string'],
        ];
    }
}
