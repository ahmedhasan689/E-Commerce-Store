<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\SessionRepository;
use App\Repositories\Cart\CookieRepository;
use App\Repositories\Cart\DatabaseRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /* singleton 
        // $repo = new SessionRepository();

        // $this->app->instance(CartRepository::class, $repo);
        */

        // app => Serveice Container / singleton() => To Add In Serveice Container  
        $this->app->bind(CartRepository::class, function($app) {

            if (config('cart.driver') == 'cookie'){
                return new CookieRepository();
            }

            if (config('cart.driver') == 'session'){
                return new SessionRepository();
            }

            return new DatabaseRepository();
            
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
