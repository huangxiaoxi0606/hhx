<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExTxt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ExTxt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $path = 'D:\laragon\laragon\www\website\public\static\images\activity\newyear\mobile';///当前目录
        $handle = opendir($path); //当前目录
        $pre = 'https://www.fnjiasu.com/static/images/activity/newyear/mobile/';
        while (false !== ($file = readdir($handle))) { //遍历该php文件所在目录
            list($filesname, $kzm) = explode(".", $file);//获取扩展名
            if ($kzm == "png" or $kzm == "jpg" or $kzm == "JPG") { //文件过滤
                if (!is_dir('./' . $file)) { //文件夹过滤
                    file_put_contents("test.txt", $pre.$file.PHP_EOL, FILE_APPEND);
//                    $array[] = $file;//把符合条件的文件名存入数组
                }
            }
        }
//        Log::info($array);
    }
}
