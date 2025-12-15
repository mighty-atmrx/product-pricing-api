<?php

namespace App\Exception;

use RuntimeException;

class PaymentFailedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('payment_failed');
    }
}
