<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Expenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '账单整理';

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
        $direc = [
            "C5" => 4,
            "C6" => 5,
            "C1" => 2,
            "C11" => 5,
            "C7" => 7,
            "C4" => 6,
            "C66" =>3,

        ];
        $week = [
            "Sunday" => 0,
            "Saturday" => 6,
            "Thursday" => 4,
            "Wednesday" => 3,
            "Tuesday" => 2,
            "Monday" => 1,
            "Friday" => 5,
        ];
        $file_path = public_path('storage/hhx/3.txt');
        $d = [];
        if (file_exists($file_path)) {
            $file_contents = file($file_path);

            for ($i = 0; $i < count($file_contents); $i++) {//逐行读取文件内容
                $arr = explode(' ', $file_contents[$i]);
                $h['status'] = $arr[1] == '-' ? 0 : 1;
                $h['money'] = $arr[3];
                $h['created_at'] = '2019-' . str_replace("/", "-", $arr[4]);
                $h['week_day'] = $week[$arr[5]];
                $h['direction_id'] = isset($direc[$arr[6]]) ? $direc[$arr[6]] : 9;
                $h['illustration'] = isset($arr[8]) && $arr[8] != "\r\n" ? $arr[8] : '无';
                $h['daily_id'] = 6666;
                $d[] = $h;
            }
        }
        if (count($d) > 0) {
            DB::table("direction_logs")->insert(array_reverse($d));
        }
    }

}
