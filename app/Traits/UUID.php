<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUID
{
    public static function boot()
    {
        parent::boot();
        // Write Log
        static::creating(function ($model) {
            if ($model->getKey() === null) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    public function getIncrementing ()
    {
        return false;
    }

    // Helps the application specify the field type in the database
    public function getKeyType ()
    {
        return 'string';
    }
}
