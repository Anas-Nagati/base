<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = ['name', 'domain', 'api_key'];

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
