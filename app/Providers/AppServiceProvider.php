<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Validator::extend('filter', function($attribute, $value, $params){
            foreach ($params as $word) {
                if (stripos($value, $word) !== false) {
                    return false;
                }
            }
            return true;
        }, 'Some Words Are Not Allowed !');

        // To Use Bootstrap Not Tailwindcss

        Paginator::useBootstrap();
    }
}
