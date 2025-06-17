<?php

namespace Modules\Tenants\App\Models;

use App\Models\User;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    protected $fillable = [
        'name',
        'domain',
        'user_id'
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class);
    }
}
