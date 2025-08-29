<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Entry;

class EntryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'your-name' => 'required|string|max:255',
            'your-email' => 'required|email|max:255',
            'your-subject' => 'required|string|max:255',
            'your-message' => 'nullable|string',
        ]);

        $entry = Entry::create($validated);

        return response()->json([
            'success' => true,
            'entry' => $entry
        ], 201);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
