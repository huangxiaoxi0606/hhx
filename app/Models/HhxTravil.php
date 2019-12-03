<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HhxTravil extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if ($model->status == '4') {
                TravilBill::where('hhx_travil_id', $model->id)->update(['status' => 1]);
                TravilEquip::where('hhx_travil_id', $model->id)->update(['status' => 4]);
            }
        });
    }

    public static function getName()
    {
        return HhxTravil::query()->limit(7)->orderBy('id', 'desc')->pluck('name', 'id');
    }
}
