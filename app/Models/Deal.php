<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model_type',
        'model_id',
        'contact_id',
        'contact_name',
        'service_id',
        'service_name',
        'user_id',
        'status',
        'priority',
        'type',
        'total',
        'headcounts',
        'probability',
        'price',
        'last_updated_at',
        'start_time',
        'end_time',
    ];
}
