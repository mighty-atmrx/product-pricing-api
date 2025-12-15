<?php

namespace App\Exception;

use Exception;

class PaymentProcessorNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('payment_processor_not_found');
    }
}
