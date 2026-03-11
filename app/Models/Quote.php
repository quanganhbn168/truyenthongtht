<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company_name',
        'service_id',
        'budget_range',
        'note',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
