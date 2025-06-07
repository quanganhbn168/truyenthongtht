<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    /** @use HasFactory<\Database\Factories\SlideFactory> */
    use HasFactory;
    protected $table = 'slides';

    protected $fillable = [
        'title',
        'image',
        'link',
        'position',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'position' => 'integer',
    ];
}
