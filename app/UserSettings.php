<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $table = "users_settings";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'age', 'bio', 'avatar', 'invites',
        'invited_by', 'rank_level'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getInvited()
    {
        if ($this->invited_by !== null) {
            return User::find($this->invited_by);
        }

        return false;
    }
}
