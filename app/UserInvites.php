<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvites extends Model
{
    protected $table = "user_invites";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'code'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
