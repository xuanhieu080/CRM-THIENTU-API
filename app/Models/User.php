<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email_verified_at',
        'email',
        'password',
        'verify_code',
        'code_expired_at',
        'created_by',
        'full_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verify_code',
        'code_expired_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'name'
    ];

    public static function boot()
    {
        parent::boot();
        // Write Log
        static::creating(function ($model) {
            $model->full_name = trim($model->first_name . ' ' . $model->last_name);
        });

        static::updating(function ($model) {
            static::creating(function ($model) {
                $model->full_name = trim($model->first_name . ' ' . $model->last_name);
            });
        });

        static::saving(function ($model) {
            static::creating(function ($model) {
                $model->full_name = trim($model->first_name . ' ' . $model->last_name);
            });
        });

    }

    public function getNameAttribute()
    {
        $name = "$this->first_name $this->last_name";
        return trim($name);
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
