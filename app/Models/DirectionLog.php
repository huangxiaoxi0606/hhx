<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class DirectionLog extends Model
{
    public static $status = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
//            if (config('transfer') != 0) {
//                $model->money = round($model->money * config('transfer'), 2);
//            }
            if ($model->daily_id != 0) {
                if ($model->status == 0) {
                    DB::table('dailies')->whereId($model->daily_id)->increment('money', $model->money);
                    Direction::whereId($model->direction_id)->increment('all_num', $model->money);
                } else {
                    DB::table('dailies')->whereId($model->daily_id)->decrement('money', $model->money);
                    Direction::whereId($model->direction_id)->decrement('all_num', $model->money);
                }
            }
            if ($model->direction_id == 6 && strpos($model->illustration, '票') == false) {
                $das['direction_id'] = $model->id;
                $das['hhx_travel_id'] = HhxTravel::query()->max('id');
                $das['created_at'] = Carbon::now();
                DB::table('travel_bills')->insert($das);
                DB::table('hhx_travels')->where('id', $das['hhx_travel_id'])->increment('money', $model->money);
            }
        });
    }

    public static function getIllustration()
    {
        return DirectionLog::query()->limit(7)->orderBy('id', 'desc')->pluck('illustration', 'id');
    }

    public static function getData($type = 1)
    {
        $now = time();
        switch ($type) {
            case 1:
                $start = date("Y-m-d", strtotime("this week"));
                break;
            case 2:
                $start = date('Y-m-01', strtotime(date("Y-m-d")));
                break;
            case 3:
                $start = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y', $now)));
                break;
            default:
                $start = '2019-01-01';
        }

        $directions = Direction::query()->select('name', 'id')->get();
        foreach ($directions as $direction) {
            $data[$direction->name] = DirectionLog::whereBetween('created_at', [$start, Carbon::now()])->where('direction_id', $direction->id)->sum('money');
        }
        return $data;
    }

    public static function getSummaryData()
    {
        $week_again = date("Y-m-d", strtotime("this week"));
        $mouth_again = date('Y-m-01', strtotime(date("Y-m-d")));
        $data['week'] = DirectionLog::whereBetween('created_at', [$week_again, Carbon::now()])->sum('money');
        $data['mouth'] = DirectionLog::whereBetween('created_at', [$mouth_again, Carbon::now()])->sum('money');
        return $data;
    }

    /**
     * 表头
     * @return string
     */
    public static function getSurplu()
    {
        $mouth_again = date('Y-m-01', strtotime(date("Y-m-d")));
        $now = Carbon::now();
        $directions = Direction::query()->select('id', 'stock', 'name')->get();
        $html = '<table class="table table-hover">
        <tr>
        <td><strong>标识</strong></td>
        <td><strong>名称</strong></td>
        <td><strong>月初</strong></td>
        <td><strong>已使用</strong></td>
        <td><strong>剩余</strong></td>
';
        foreach ($directions as $v) {
            $used = DirectionLog::whereBetween('created_at', [$mouth_again, $now])->where('direction_id', $v->id)->sum('money');
            $t = $v->stock - $used;
            $flag = $t >= 0 ? '<span class="glyphicon glyphicon-ok" ></span>' : '<span class="glyphicon glyphicon-remove" ></span>';
            $html = $html . '<tr>
                <td>' . $flag . '</td>
                <td><b>' . $v->name . '</b></td>
                <td>' . $v->stock . '</td>
                <td>' . $used . '</td>
                <td>' . $t . '</td></tr>';
        }
        $html = $html . '</table>';
        return $html;
    }


    public static function getSurplus()
    {
        $mouth_again = date('Y-m-01', strtotime(date("Y-m-d")));
        $now = Carbon::now();
        $directions = Direction::query()->select('id', 'stock', 'name')->get();
        $data = [];
        foreach ($directions as $v) {
            $used = DirectionLog::whereBetween('created_at', [$mouth_again, $now])->where('direction_id', $v->id)->sum('money');
            $t = $v->stock - $used;
            $d[] = $v->name;
            $d[] = $v->stock;
            $d[] = $used;
            $d[] = $t;
            $data[] = $d;
            unset($d);
        }
        return $data;
    }


    /**
     * 微信解析记账存入
     * @param $data
     */
    public static function parseContent($data)
    {
        $arrs = explode(',', $data);
//        unset($arrs[0]);
        $dl = new DirectionLog();
        $dl->direction_id = $arrs[1];
        $dl->daily_id = $arrs[2];
        $dl->status = $arrs[3];
        $dl->ok = 0;
        $dl->illustration = $arrs[4];
        $dl->note = $arrs[5];
        $dl->money = $arrs[6];
        $dl->week_day = $arrs[7];
        $dl->save();
    }

    public static function findOrFail($id)
    {
    }
}
