<?php

namespace App\Admin\Controllers;

class CoffeeController extends AssetCommonController
{
    public function __construct()
    {
        $this->commName = 'Coffee';
        $this->str = 'coffee';
    }
}
