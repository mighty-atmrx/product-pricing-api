<?php

namespace App\Exception;

use Exception;

class InvalidTaxNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct('invalid_tax_number');
    }
}
