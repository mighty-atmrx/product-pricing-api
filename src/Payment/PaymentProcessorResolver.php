<?php

declare(strict_types=1);

namespace App\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentProcessorNotFoundException;
use App\Interface\PaymentProcessorInterface;

readonly class PaymentProcessorResolver
{
    /**
     * @param iterable<PaymentProcessorInterface> $processors
     */
    public function __construct(
        private iterable $processors
    ){
    }

    /**
     * @throws PaymentProcessorNotFoundException
     */
    public function getProcessor(PaymentProcessorType $processorType): PaymentProcessorInterface
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($processorType)) {
                return $processor;
            }
        }

        throw new PaymentProcessorNotFoundException();
    }
}
