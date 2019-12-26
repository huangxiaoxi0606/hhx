<?php

namespace App\Admin\Controllers;

class ClothesController extends AssetCommonController
{
    public function __construct()
    {
        $this->commName = 'Clothes';
        $this->str = 'clothes';
    }
}
