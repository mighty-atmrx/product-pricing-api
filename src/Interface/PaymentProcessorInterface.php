<?php

declare(strict_types=1);

namespace App\Interface;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;

interface PaymentProcessorInterface
{
    /**
     * @throws PaymentFailedException
     */
    public function pay(float $amount): void;

    public function supports(PaymentProcessorType $processorType): bool;
}
