<?php

namespace App\Http\Controllers\Python;

use App\Models\Damai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaMaiController extends Controller
{
    public function getData()
    {
        $datas = Damai::query()->paginate(20);
        $data['data'] = $datas;
        return view('Home.DaMai.list', $data);
    }
}
