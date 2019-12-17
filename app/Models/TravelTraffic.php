<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TravelTraffic extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            DB::table('hhx_travels')->where('id', $model->hhx_travel_id)->increment('money', $model->money);
        });
    }
}
