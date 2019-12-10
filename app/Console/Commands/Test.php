<?php

namespace App\Console\Commands;

use App\Handlers\DailyHandler;
use App\Models\DbMovie;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use App\Models\WeiboPics;
use App\Models\WeiboUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试专用';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        DailyHandler::text();
//        $data = "兴趣,2,3,shuoming,1";
//        InterestLog::parseContent($data);
//        $disk = Storage::disk('qiniu');
//        create a file
//        $weibo_pics = \App\Models\DbMusicTop::pluck('img')->toArray();
//        $arrs = array_chunk($weibo_pics, 20);
//        foreach ($arrs as $ar) {
//            foreach ($ar as $pic) {
//                $p = Storage::get($pic);
//                $disk->put($pic, $p);
//            }
//        }
//        dd('961');
//        $disk = Storage::disk('public');
//        $directory = '/weibo_user_h/';
//        $allFiles = $disk->allFiles($directory);
//        dd($allFiles);
    }
}
