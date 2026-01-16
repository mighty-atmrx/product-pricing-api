<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentProcessorTypeEnum;
use App\Exception\PaymentFailedException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentAdapter implements PaymentAdapterInterface
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

    public function supports(PaymentProcessorTypeEnum $processorType): bool
    {
        return $processorType === PaymentProcessorTypeEnum::STRIPE;
    }
}
