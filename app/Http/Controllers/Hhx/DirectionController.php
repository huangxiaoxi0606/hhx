<?php
/**
 * Created by PhpStorm.
 * User: Hhx
 * Date: 2020/1/2
 * Time: 9:40
 */

namespace App\Http\Controllers\Hhx;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use Illuminate\Support\Facades\Request;

class DirectionController extends Controller
{
    public function getDirection(Request $request)
    {
        $datas = Direction::query()->get();
        $data['data'] = $datas;
        return view('Home.Hhx.direction', $data);
    }

}
