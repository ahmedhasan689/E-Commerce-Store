<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use Illuminate\Http\Resources\Json\JsonResource;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('paypal.client', function($app) {
            $config = config('services.paypal');

            if($config['mode'] == 'sandbox') {
                $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
            }else{
                $environment = new ProductionEnvironment($config['client_id'], $config['client_secret']);
            }

            $client =  new PayPalHttpClient($environment);

            return $client;
        });
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
