<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar',
        'position_name',
        'message',
        'contact_funnel_id',
        'contact_source_id',
        'lead_status_id',
        'contact_id',
        'service_id',
        'last_updated_at'
    ];
}
