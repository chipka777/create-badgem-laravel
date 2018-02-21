<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UserHistory extends Model
{
    protected $table = "user_histories";

    protected $fillable = [
        'id', 'user_id', 'name',
        'content', 'icon'
    ];

    private $path = 'vendor.histories.';
    
    public function createFromTemplate($tmpName, $user, $data = [])
    { 
        return $this->create([
            'user_id' => $user->id,
            'name' => $tmpName,
            'content' => json_encode($data),
        ]);
    }

    public function getStringFromTemplate()
    {

    }
}
