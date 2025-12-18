<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentProcessorNotFoundException;

readonly class PaymentProcessorResolver
{
    /**
     * @param iterable<PaymentAdapterInterface> $processors
     */
    public function __construct(
        private iterable $processors
    ){
    }

    /**
     * @throws PaymentProcessorNotFoundException
     */
    public function getProcessor(PaymentProcessorType $processorType): PaymentAdapterInterface
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($processorType)) {
                return $processor;
            }
        }

        throw new PaymentProcessorNotFoundException();
    }
}
