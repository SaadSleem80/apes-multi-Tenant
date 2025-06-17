<?php

namespace Modules\Tenants\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Users\App\Http\Resources\UserResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'domain'        => $this->domain,
            'user'          => new UserResource($this->user),
            'created_at'    => $this->created_at->toDateTimeString(),
        ];
    }
}
