<?php

namespace App\Http\ApiV1\Modules\Clients\Resources;

use App\Domain\Clients\Models\Clients;
use App\Http\ApiV1\Support\Resources\BaseJsonResource;

/**
 * @mixin Clients
 */
class DeleteResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => null,
        ];
    }
}