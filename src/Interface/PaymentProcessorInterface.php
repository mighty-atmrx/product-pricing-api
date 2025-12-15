<?php

namespace App\Interface;

use App\Exception\PaymentFailedException;

interface PaymentProcessorInterface
{
    /**
     * @throws PaymentFailedException
     */
    public function pay(float $amount): void;
}
