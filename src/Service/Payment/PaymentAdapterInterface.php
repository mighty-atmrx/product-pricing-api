<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;

interface PaymentAdapterInterface
{
    /**
     * @throws PaymentFailedException
     */
    public function pay(float $amount): void;

    public function supports(PaymentProcessorType $processorType): bool;
}
