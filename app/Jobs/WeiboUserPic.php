<?php

namespace App\Jobs;

use App\Models\WeiboUser;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeiboUserPic implements ShouldQueue
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
        $arr = [];
        //用户头像以及封面
        $weiboUsers = WeiboUser::select('id', 'avatar_hd', 'cover_image_phone')->get();
        $num = 0;
        $num2 = 100;
        foreach ($weiboUsers as $user) {
            if ($user->avatar_hd && strpos($user->avatar_hd, 'https') !== false) {
                $url = $user->avatar_hd;
                $num = $num + 1;
                $e = time() . $num . '.jpg';
                $filename = 'storage/weibo_user_t/' . $e;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url, ['save_to' => public_path($filename)]);
                $arr[] = $filename;
                $url2 = $user->cover_image_phone;
                $num2 = $num2 - 1;
                $e2 = time() . $num2 . '.jpg';
                $filename2 = 'storage/weibo_user_t/' . $e2;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url2, ['save_to' => public_path($filename2)]);
                $user->avatar_hd = 'weibo_user_t/' . $e;
                $user->cover_image_phone = 'weibo_user_t/' . $e2;
                $user->save();
                $arr[] = $user->avatar_hd;
                $arr[] = $user->cover_image_phone;
            }
        }
        if (count($arr) > 0) {
            Log::info("weiboupic s");
            //存入七牛云
            $disk = Storage::disk('qiniu');
            $arrs = array_chunk($arr, 20);
            foreach ($arrs as $ar) {
                foreach ($ar as $pic) {
                    $p = Storage::get($pic);
                    $disk->put($pic, $p);
                }
            }
            Log::info("weiboupic e");

        }
    }
}
