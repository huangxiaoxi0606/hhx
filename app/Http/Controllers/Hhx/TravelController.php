<?php
/**
 * Created by PhpStorm.
 * User: Hhx
 * Date: 2019/12/27
 * Time: 18:03
 */

namespace App\Http\Controllers\Hhx;

use App\Http\Controllers\Controller;
use App\Models\HhxTravel;
use Illuminate\Support\Facades\Request;

class TravelController extends Controller
{
    public function getList(Request $request)
    {
        $datas = HhxTravel::query()->paginate(20);
        $data['data'] = $datas;
        return view('Home.Hhx.travel_list', $data);
    }

    public function getIntro(Request $request, $id)
    {
        $datas = HhxTravel::whereId($id)->first();
        $data['data'] = $datas;
        return view('Home.Hhx.travel_intro', $data);
    }

}
