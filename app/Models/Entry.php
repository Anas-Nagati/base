<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table = 'entries';

    protected $fillable = [
        'your-name',
        'your-email',
        'your-subject',
        'your-message',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
