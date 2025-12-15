<?php

namespace App\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('product_not_found');
    }
}
