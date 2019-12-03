<?php
/**
 * Created by PhpStorm.
 * User: a123
 * Date: 2019-10-02
 * Time: 11:44
 */

namespace App\Handlers;

use App\Models\Daily;
use App\Models\Direction;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use App\Models\Weibo;
use App\Models\WeiboPics;
use Carbon\Carbon;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class DailyHandler
{
    public static function getData()
    {
        $daily = Daily::orderBy('id', 'desc')->first();
        $direction_logs = DirectionLog::where('daily_id', $daily->id)->get();
        $interest_logs = InterestLog::where('daily_id', $daily->id)->get();
        $yesterDate = Carbon::yesterday()->toDateString();
        $week = date("w", time() - 36400);
        $weeks = [0 => '日', 1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六'];
        $weibos = Weibo::query()->where('weibo_created_at', '>', $yesterDate)->where('is_flag', 0)->get()->toArray();
        if ($weibos) {
            foreach ($weibos as $key => $weibo) {
                if ($weibo['pic_num'] > 1) {
                    $pics = WeiboPics::query()->where('weibo_info_id', $weibo['weibo_info_id'])->limit($weibo['pic_num'])->pluck('url')->toArray();
                    $weibos[$key]['pics'] = $pics;
                } else {
                    $weibos[$key]['pics'] = '';
                }
            }
        }
        $data = [
            'daily' => $daily,
            'direction_logs' => $direction_logs,
            'interest_logs' => $interest_logs,
            'week' => $weeks[$week],
            'yesterDate' => $yesterDate,
            'weibos' => $weibos
        ];
        return $data;
    }

    public static function getHhx()
    {
        $view = 'Emails.Daily';
        $data = DailyHandler::getData();
        $toMail = 'hhx06@outlook.com';
        Mail::send($view, $data, function ($message) use ($toMail) {
            $message->subject('[ daily] 日报 - ' . date('Y-m-d'));
            $message->to($toMail);
        });
        Log::info(date('Y-m-d') . 'daily its ok');
    }

    public static function getWeekData()
    {
        $week_again = date("Y-m-d", strtotime("this week"));
        $dailys = Daily::where('created_at', '>', $week_again)->get();
        $daily_ids = $dailys->pluck('id')->toArray();
        $daily_summary = $dailys->pluck('summary')->toArray();
        $daily_grow_up = $dailys->pluck('grow_up')->toArray();
        $daily_Img = $dailys->pluck('Img')->toArray();
        $daily_collocation = $dailys->pluck('collocation')->toArray();
        $directionLogs = DirectionLog::whereIn('daily_id', [$daily_ids])->get();
        $directionSum = $directionLogs->sum('money');
        $interest_logs = InterestLog::whereIn('daily_id', [$daily_ids])->get();
        $weibos = Weibo::where('weibo_created_at', '>', $week_again)->where('is_flag', 0)->get()->toArray();
        if ($weibos) {
            foreach ($weibos as $key => $weibo) {
                if ($weibo['pic_num'] > 1) {
                    $pics = WeiboPics::where('weibo_info_id', $weibo['weibo_info_id'])->limit($weibo['pic_num'])->pluck('url')->toArray();
                    $weibos[$key]['pics'] = $pics;
                } else {
                    $weibos[$key]['pics'] = '';
                }
            }
        }
        $data = [
            'week_again' => $week_again,
            'dailys' => $dailys,
            'direction_logs' => $directionLogs,
            'directionSum' => $directionSum,
            'interest_logs' => $interest_logs,
            'daily_summary' => $daily_summary,
            'daily_grow_up' => $daily_grow_up,
            'daily_Img' => $daily_Img,
            'daily_collocation' => $daily_collocation,
            'weibos' => $weibos,
        ];
        return $data;
    }

    public static function getHhxWeek()
    {
        $view = 'Emails.Week';
        $data = DailyHandler::getWeekData();
        $toMail = 'hhx06@outlook.com';
        Mail::send($view, $data, function ($message) use ($toMail) {
            $week_again = date("Y-m-d", strtotime("this week"));
            $message->subject('[week] 周报 - ' . $week_again . '-' . date('Y-m-d'));
            $message->to($toMail);
        });
        Log::info(date('Y-m-d') . 'week its ok');
    }


    public static function sendMessage()
    {
        $app = app('wechat.official_account');
        $message = new Text('Hello world!');
        $openId = 'oUCgBwP5gOn79QGN60Fb9GS19kwk';
        $result = $app->customer_service->message($message)->to($openId)->send();
        return $result;
    }

    /**
     * 月初额度更新
     */
    public static function updateStock()
    {
        $directions = Direction::query()->get();
        $last_month = strtotime("-1 month");
        $last_month_first = date("Y-m-01 00:00:00", $last_month);//上个月第一天`
        $now = Carbon::now();
        foreach ($directions as $v) {
            $used = DirectionLog::whereBetween('created_at', [$last_month_first, $now])->where('direction_id', $v->id)->sum('money');
            $v->stock = $v->stock - $used + config($v->name);
            $v->save();
        }
        Log::info(date('Y-m-d') . 'stock its ok');
    }


//    static public function getMouth(){
//        $now = Carbon::now();
//        $year = $now->year;
//        $mouth = $now->month;
//        $directions = Direction::query()->get();
//        $data = [];
//        for($i = 1;$i <= $mouth;$i++){
//            $start = $year.'-'.$i.'-01';
//            $end =  Carbon::parse($start)->addMonth();
//            $d[] = $start;
//            foreach ($directions as $v){
//                $d[] = DirectionLog::whereBetween('created_at',[$start,$end])->where('direction_id',$v->id)->sum('money');
//            }
//            $data[] = $d;
//            unset($d);
//        }
//        return array_reverse($data);
//
//    }
    public static function text()
    {
        $ar = array(
            2 => array(
                'catid' => '6',
                'catdir' => '2018-03-28 22:06:28',//2018-03-29 22:06:28
            ),
            6 => array(
                'catid' => '5',
                'catdir' => '2018-03-29 21:15:51'//2018-03-29 21:15:51
            ),
            7 => array(
                'catid' => '3',
                'catdir' => '2018-03-28 20:56:15'//2018-03-29 20:56:15
            ),
            9 => array(
                'catid' => '3',
                'catdir' => '2018-03-29 20:49:32'//2018-03-29 20:49:32
            ),
            10 => array(
                'catid' => '2',
                'catdir' => '2018-03-29 20:49:32'//2018-03-29 20:09:11
            ),
            5 => array(
                'catid' => '2',
                'catdir' => '2018-03-28 19:40:06',//2018-03-29 19:40:06
            ),
        );
        $catdir_so1 = "2018-03-29";
        $catdir_so2 = "2018-03-30";
        $r = array_filter($ar, function ($t) use ($catdir_so1, $catdir_so2) {
            return $t['catdir'] > $catdir_so1 and $t['catdir'] < $catdir_so2;
        });
        print_r($r);
    }

}
