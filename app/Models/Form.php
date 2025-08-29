<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'form_id',
        'title',
        'fields',
        'sheet_id'
    ];

    protected $casts = [
        'fields' => 'array', // JSON → PHP array
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
