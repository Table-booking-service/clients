<?php

namespace App\Http\ApiV1\Modules\Clients\Resources;

use App\Domain\Clients\Models\Clients;
use App\Http\ApiV1\Support\Resources\BaseJsonResource;

/**
 * @mixin Clients
 */
class ClientResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'fio' => $this->fio,
            'phone_number' => $this->phone_number,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}