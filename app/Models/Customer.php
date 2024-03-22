<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
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

    protected $appends = [
        'name',
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

    public function companies() {
        return $this->belongsToMany(Company::class,'customer_companies','customer_id', 'company_id');
    }

    public function contactSource() {
        return $this->hasOne(ContactSource::class,'id', 'contact_source_id');
    }

    public function contactFunnel() {
        return $this->hasOne(ContactFunnel::class,'id', 'contact_funnel_id');
    }

    public function leadStatus() {
        return $this->hasOne(LeadStatus::class,'id', 'lead_status_id');
    }

    public function contact() {
        return $this->hasOne(User::class,'id', 'contact_id');
    }

    public function service() {
        return $this->hasOne(Service::class,'id', 'service_id');
    }
}
