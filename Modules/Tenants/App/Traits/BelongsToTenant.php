<?php

namespace Modules\Tenants\App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

trait BelongsToTenant
{
    use UsesTenantConnection;

    public static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = app('currentTenant');

            if ($tenant) {
                $builder->where('tenant_id', $tenant->id);
            }
        });

        static::creating(function ($model) {
            if (app('currentTenant') && ! $model->tenant_id) {
                $model->tenant_id = app('currentTenant')->id;
            }
        });
    }
}
