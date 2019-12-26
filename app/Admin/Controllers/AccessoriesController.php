<?php

namespace App\Admin\Controllers;

class AccessoriesController extends AssetCommonController
{
    public function __construct()
    {
        $this->commName = 'Accessories';
        $this->str = 'accessories';
    }

}
