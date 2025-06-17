<?php

namespace Modules\Bookings\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Teams\App\Models\Team;
use Modules\Tenants\App\Traits\BelongsToTenant;

class Booking extends Model
{
    use HasFactory, BelongsToTenant;
    protected $fillable = [
        'team_id',
        'tenant_id',
        'start_time',
        'end_time',
        'date'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
