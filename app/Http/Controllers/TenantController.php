<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function create(Request $request)
    {
        // 1) Validate input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'domain'      => 'required|string|max:255|unique:tenants,domain',
            'owner_email' => 'nullable|email|max:255',
            'plan'        => 'in:free,paid',
        ]);

        // 2) Check if tenant already exists by email (optional rule)
        if (!empty($validated['owner_email'])) {
            $existing = Tenant::where('owner_email', $validated['owner_email'])->first();
            if ($existing) {
                return response()->json([
                    'message' => 'A tenant with this email already exists.',
                    'tenant'  => $existing,
                ], 409); // Conflict
            }
        }

        // 3) Generate a unique API token
        $apiToken = $this->generateApiToken();
        while (Tenant::where('api_token', $apiToken)->exists()) {
            $apiToken = $this->generateApiToken(); // regenerate if duplicate
        }

        // 4) Create the tenant
        $tenant = Tenant::create([
            'name'        => $validated['name'],
            'domain'      => $validated['domain'],
            'owner_email' => $validated['owner_email'] ?? null,
            'plan'        => $validated['plan'] ?? 'free',
            'status'      => 'active',
            'api_token'   => $apiToken,
        ]);

        return response()->json([
            'message' => 'Tenant created successfully',
            'tenant'  => $tenant,
        ], 201);
    }

    private function generateApiToken(): string
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < 16; $i++) {
            $token .= $letters[random_int(0, strlen($letters) - 1)];
        }

        return implode('-', str_split($token, 4)); // XXXX-XXXX-XXXX-XXXX
    }
}
