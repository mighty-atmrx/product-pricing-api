<?php

namespace App\Exception;

use Exception;

class PaymentFailedException extends Exception
{
    public function __construct()
    {
        parent::__construct('payment_failed');
    }
}
