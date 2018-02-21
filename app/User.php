<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'email', 'password', 'verify_code', 'invite_code', 'acivated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function meta()
    {
        return $this->hasOne(UserMeta::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function histories()
    {
        return $this->hasMany(UserHistory::class);
    }


}
