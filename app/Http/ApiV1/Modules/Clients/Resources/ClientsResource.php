<?php

namespace App\Http\ApiV1\Modules\Clients\Resources;

use App\Domain\Clients\Models\Clients;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin Clients
 */
class ClientsResource extends ResourceCollection
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return ['data' => $this->collection];
    }
}
