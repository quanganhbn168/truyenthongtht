<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
        'is_active',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_active' => 'boolean',
    ];
}
