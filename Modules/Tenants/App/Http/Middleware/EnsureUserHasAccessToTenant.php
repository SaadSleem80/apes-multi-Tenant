<?php

namespace Modules\Tenants\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasAccessToTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = app('currentTenant');

        if($request->user()->id != $tenant->user_id) {
            abort(403, 'You do not have access to this tenant.');
        }

        return $next($request);
    }
}
