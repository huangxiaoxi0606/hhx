<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestLog extends Model
{
    protected $fillable = ['illustration', 'week_day', 'interest_id'];

    public function daily()
    {
        return $this->belongsTo(Daily::class, 'daily_id');
    }

    public static function parseContent($data)
    {
        $arrs = explode(',', $data);
//        unset($arrs[0]);
        $dl = new InterestLog();
        $dl->interest_id = $arrs[1];
        $dl->daily_id = $arrs[2];
        $dl->illustration = $arrs[3];
        $dl->week_day = $arrs[4];
        $dl->save();
    }


}
