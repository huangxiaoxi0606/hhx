<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    //
    public static function getData()
    {
        return Interest::whereStatus(0)->orderBy('order_num')->pluck('name', 'id');
    }
}
