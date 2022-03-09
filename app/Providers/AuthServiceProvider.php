<?php

namespace App\Providers;

use App\Models\Role;
use Laravel\Sanctum\Sanctum;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $abilities) {
            if ($user->type == 'super-admin') {
                return true;
            }

            if ($user->type == 'user') {
                return false;
            }

        });

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }





}
