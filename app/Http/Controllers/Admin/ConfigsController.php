<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Currencies;
use Illuminate\Support\Facades\Artisan;

class ConfigsController extends Controller
{
    public function create()
    {
        return view('admin.configs', [
            'currencies' => Currencies::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->input('config') as $key => $value) {
            Config::setValue($key, $value);
        }

        Cache::forget('app-settings');

        return redirect()->route('settings')->with('success', 'Settings Saved !');
    }

    public function clearCache()
    {
        Artisan::command('cache:clear', function($app) {
            return redirect()->route('settings')->with('success', 'Cache Cleared!');
        });
        // return redirect()->route('settings')->with('success', 'Cache Cleared!');
    }

}
