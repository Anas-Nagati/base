<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use App\Models\Tenant;

class VerifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-API-TOKEN');

        if (!$token) {
            return response()->json(['error' => 'Missing API token'], 401);
        }


        $token = str_replace('Bearer ', '', $token);
        $tenant = Tenant::where('api_token', $token)->first();

        if (!$tenant || $tenant->status !== 'active') {
            return response()->json(['error' => 'Invalid or inactive tenant'], 403);
        }

        // Attach tenant to request for controllers
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
