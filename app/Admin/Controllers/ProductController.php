<?php

namespace App\Admin\Controllers;

class ProductController extends AssetCommonController
{
    public function __construct()
    {
        $this->commName = 'Product';
        $this->str = 'product';
    }
}
