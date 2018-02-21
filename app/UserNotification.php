<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = "user_notifications";

    protected $fillable = [
        'id', 'user_id', 'name',
        'content', 'link', 'target', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send($user, $name, $content, $link = NULL, $target = 'self', $status = 'success')
    {
        $data = [
            'user_id' => $user->id,
            'name' => $name,
            'content' => $content,
            'link' => $link,
            'target' => $target,
            'status' => $status,
        ];

        return $this->create($data);
    }
}
