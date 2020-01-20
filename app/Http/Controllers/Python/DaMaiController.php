<?php

namespace App\Http\Controllers\Python;

use App\Models\Damai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaMaiController extends Controller
{
    public function getData()
    {
        $data = Damai::query()->paginate(20);
        return view('Home.DaMai.list', ['data'=>$data]);
    }
}
