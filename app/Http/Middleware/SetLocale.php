<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class SetLocale
{
    
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->query('lang', session('lang'));

        if ($lang) {
            App::setLocale($lang);
            session()->put('lang', $lang);
        }

        // To Set Default Value For {lang} in Route ...
        // URL::defaults([
        //     'lang' => App::currentLocale(),
        // ]);

        // Route::current()->forgetParameter('lang');
        
        return $next($request);
    }
}
