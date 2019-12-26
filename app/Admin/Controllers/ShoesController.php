<?php

namespace App\Admin\Controllers;

class ShoesController extends AssetCommonController
{
    public function __construct()
    {
        $this->commName = 'Shoes';
        $this->str = 'shoes';
    }
}
