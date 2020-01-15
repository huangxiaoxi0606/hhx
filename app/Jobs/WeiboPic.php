<?php

namespace App\Jobs;

use App\Models\Weibo;
use App\Models\WeiboPics;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class WeiboPic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //微博表中图片更新
        $num = 0;
        $arr = [];
        Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id', 'thumbnail_pic')->chunk(100, function ($weibos) use ($num, $arr) {
            foreach ($weibos as $weibo) {
                if ($weibo->thumbnail_pic) {
                    $url = $weibo->thumbnail_pic;
                    $num = $num + 1;
                    $e = time() . $num . '.jpg';
                    $filename = '/storage/weibo_pic_t/' . $e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $data[$weibo->id] = 'weibo_pic_t/' . $e;
                    $client->get($url, ['save_to' => public_path($filename)]);
                    $arr[] = $data[$weibo->id];
                }
            }
            if (!empty($data)) {
                foreach ($data as $k => $v) {
                    $we = Weibo::where('id', $k)->first();
                    $we->thumbnail_pic = $v;
                    $we->save();
                }
            }
        });
        WeiboPics::whereNull('updated_at')->select('id', 'url')->chunk(100, function ($weiboPic) use ($num, $arr) {
            foreach ($weiboPic as $pic) {
                if ($pic->url) {
                    $url = $pic->url;
                    $num = $num + 1;
                    $e = time() . $num . '.jpg';
                    $filename = 'storage/weibo_pic_f/' . $e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $client->get($url, ['save_to' => public_path($filename)]);
                    $pic->url = 'weibo_pic_f/' . $e;
                    $arr[] = $pic->url;
                    $pic->save();
                }
            }
        });
        dd($arr);

        if (count($arr) > 0) {
            Log::info("weibopic start");
            $disk = Storage::disk('qiniu');
            $arrs = array_chunk($arr, 20);
            foreach ($arrs as $ar) {
                foreach ($ar as $pic) {
                    $p = Storage::get($pic);
                    $disk->put($pic, $p);
                }
            }
            Log::info("weibopic end");
            //存入七牛云
        }
    }
}
