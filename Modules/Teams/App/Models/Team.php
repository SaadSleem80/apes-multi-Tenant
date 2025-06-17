<?php

namespace Modules\Teams\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Bookings\App\Models\Booking;
use Modules\Tenants\App\Traits\BelongsToTenant;

class Team extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'name',
        'tenant_id'
    ];

    public $casts = [
        'name' => 'string',
    ];

    public function teamAvailability(): HasMany
    {
        return $this->hasMany(TeamAvailability::class);
    }

    public function teamBookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search))
            return $query->where('name', 'like', '%' . $search . '%');
    }
}
