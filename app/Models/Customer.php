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
