<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/9/29
 * Time : 9:18
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\DbTop;
use Illuminate\Support\Facades\Request;

class DoubanController extends Controller
{
    public function top250(Request $request)
    {
        $data = DbTop::query()->paginate(10);
        return view('Home.Douban.top250', ['data'=>$data]);
    }
}
