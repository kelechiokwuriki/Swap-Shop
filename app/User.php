<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use App\Listing;
use App\Event;
use App\Role;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'password_needs_reset',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function passwordNeedsReset()
    {
        return $this->password_needs_reset;
    }

    public function deactivatePasswordNeedsReset()
    {
        $this->password_needs_reset = 0;
    }

    public function getApiTokenAttribute($value)
    {
        if(!$value) {
            $value = Str::random(80);
            $this->api_token = $value;
            $this->save();
        }

        return $value;
    }
}
