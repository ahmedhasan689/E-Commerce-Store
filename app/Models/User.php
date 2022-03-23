<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasApiTokens; // To Generate Token For API

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var mixed
     */

    public function hasAbility($abilities)
    {
        $roles = Role::whereRaw('id IN (SELECT role_id FROM role_user WHERE user = ?)', [
            $this->id,
        ]);

        foreach ($roles as $role) {
            if (in_array($abilities, $role->abilities)) {
                return true;
            }
        }

        return false;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(User::class, 'country_id')->withDefault();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'user_id',
            'role_id',
            'id',
            'id'
        );
    }

    public function routeNotificationForMail($notification = null)
    {
        if ($notification instanceof OrderCreatedNotification){
            return $this->email;
        };
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }

    public function routeNotificationForFcm($notification = null)
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }
}
