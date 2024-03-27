<?php

namespace App\Models;

use App\Supports\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    const path = 'companies';

    protected $fillable = [
        'id',
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

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return HasImage::getImage($this->image);
    }

    public function industry() {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function contact() {
        return $this->hasOne(User::class, 'id', 'contact_id');
    }
}
