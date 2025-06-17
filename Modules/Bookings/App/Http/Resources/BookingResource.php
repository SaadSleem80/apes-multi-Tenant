<?php

namespace Modules\Bookings\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Teams\App\Http\Resources\TeamResource;
use Modules\Tenants\App\Http\Resources\TenantResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'team'          => TeamResource::make($this->whenLoaded('team')),
            'start_time'    => $this->start_time,
            'end_time'      => $this->end_time,
            'date'          => $this->date,
            'created_at'    => $this->created_at->toDateTimeString()
        ];
    }
}
