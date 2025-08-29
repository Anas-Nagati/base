<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Site;

class ValidateApiKey
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('Authorization');

        if (!$apiKey || !str_starts_with($apiKey, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $apiKey = substr($apiKey, 7); // remove "Bearer "

        $site = Site::where('api_key', $apiKey)->first();

        if (!$site) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        // Attach site/tenant to request for later use
        $request->merge([
            'site' => $site,
            'tenant' => $site->tenant
        ]);

        return $next($request);
    }
}
