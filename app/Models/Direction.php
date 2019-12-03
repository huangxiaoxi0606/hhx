<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    //
    public static function getData()
    {
        return Direction::whereStatus(0)->pluck('name', 'id');
    }
}
