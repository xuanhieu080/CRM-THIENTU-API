<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'domain',
        'phone',
        'email',
        'address',
        'description',
        'facebook_link',
        'linkedin_link',
        'industry_id',
        'contact_id',
        'lead_status_id',
    ];
}
