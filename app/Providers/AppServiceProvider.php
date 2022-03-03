<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;

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

        JsonResource::withoutWrapping();

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
