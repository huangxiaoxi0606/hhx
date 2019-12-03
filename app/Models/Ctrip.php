<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Ctrip extends Model
{
    protected $guarded = [];

    /**
     * 保存数据
     * @param $data
     * @param $name
     */
    public function saveData($data)
    {
        $ctrip = $this->searchData($data);
        if (!$ctrip) {
            $this->create($data);
        } else {
            $ctrip->updated_at = now();
            $ctrip->update($data);
        }
    }

    /**
     * 保存前查找
     * @param $data
     * @param $name
     * @return bool
     */
    public function searchData($data)
    {
        $where = [
            'depAirportCode' => $data['depAirportCode'],
            'arrAirportCode' => $data['arrAirportCode'],
        ];
        $ctrip = $this->where($where)->first();
        if ($ctrip) {
            return $ctrip;
        }
        return false;
    }
}
