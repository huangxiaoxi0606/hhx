<?php

namespace App\Console\Commands;

use App\Handlers\DailyHandler;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use Illuminate\Console\Command;

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
        $data = "兴趣,2,3,shuoming,1";
        InterestLog::parseContent($data);
    }
}
