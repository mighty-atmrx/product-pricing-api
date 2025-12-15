<?php

declare(strict_types=1);

namespace App\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private StripePaymentProcessor $paymentProcessor,
    ) {
    }

    public function pay(float $amount): void
    {
        if (!$this->paymentProcessor->processPayment($amount)) {
            throw new PaymentFailedException();
        }
    }

    public function supports(PaymentProcessorType $processorType): bool
    {
        return $processorType === PaymentProcessorType::STRIPE;
    }
}
