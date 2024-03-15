<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory, HasCompositePrimaryKeyTrait;
    protected $primaryKey = ['email'];
    protected $fillable = [
        'token',
        'email',
        'created_at',
    ];
}
