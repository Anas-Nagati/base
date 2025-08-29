<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Sync or create/update a form for the tenant.
     * WordPress plugin will call this endpoint with form data.
     */
    public function sync(Request $request)
    {

        $tenant = $request->attributes->get('tenant'); // from VerifyTenant middleware

        $validated = $request->validate([
            'form_id'  => 'required|numeric',
            'title'    => 'nullable|string',
            'fields'   => 'nullable|array',
            'sheet_id' => 'nullable|string',
        ]);

        $form = Form::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
                'form_id'  => $validated['form_id'],
            ],
            [
                'title'  => $validated['title'] ?? null,
                'fields' => $validated['fields'] ?? [],
                'sheet_id' => $validated['sheet_id'] ?? null
            ]
        );

        return response()->json([
            'message' => 'Form synced successfully',
            'form'    => $form,
        ]);
    }
}
