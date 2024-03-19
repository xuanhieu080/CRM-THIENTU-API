<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^0[0-9]{9,10}$/', $value);
        });

        Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, ':attribute không đúng định dạng');
        });
    }
}
