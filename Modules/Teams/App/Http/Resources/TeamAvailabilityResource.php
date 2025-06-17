<?php
namespace Modules\Teams\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Teams\App\Enums\WeekDays;

class TeamAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'day_of_week'   => WeekDays::fromValue($this->day_of_week)->key,
            'start_time'    => $this->start_time,
            'end_time'      => $this->end_time,
            'created_at'    => $this->created_at->toDateTimeString(),  
        ];
    }
}
