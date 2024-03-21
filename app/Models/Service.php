<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'description',
        'is_default'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
