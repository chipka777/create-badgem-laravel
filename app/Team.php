<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "team";

    protected $fillable = [
        'first_name', 'last_name',
        'description', 'image', 'type'
    ];

    const TYPES = [
        'Moderators' => 1,
        'Ambassadors' => 2,
        'Consultants' => 3,
        'Contributors' => 4
    ];

    public function getType()
    {
        foreach (self::TYPES as $key => $type) {
            if ($type == $this->type) {
                return $key;
            }
        }

        return 'All';
    }
}
