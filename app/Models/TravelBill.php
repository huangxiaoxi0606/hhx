<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TravelBill extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if ($model->direction_id != 0 && $model->flag == 1) {
                $money = DirectionLog::whereId($model->direction_id)->value('money');
                DB::table('hhx_travels')->where('id', $model->hhx_travel_id)->increment('money', $money);
            }
            unset($model['flag']);
        });
    }
}
