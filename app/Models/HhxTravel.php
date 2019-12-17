<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HhxTravel extends Modele
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if ($model->status == '4') {
                TravelBill::where('hhx_travel_id', $model->id)->update(['status' => 1]);
                TravelEquip::where('hhx_travel_id', $model->id)->update(['status' => 4]);
            }
        });
    }

    public static function getName()
    {
        return HhxTravel::query()->limit(7)->orderBy('id', 'desc')->pluck('name', 'id');
    }
}
