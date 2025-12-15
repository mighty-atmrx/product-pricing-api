<?php

declare(strict_types=1);

namespace App\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

readonly class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paymentProcessor,
    ) {
    }

    public function pay(float $amount): void
    {
        try {
            $amountInCents = (int) round($amount * 100);
            $this->paymentProcessor->pay($amountInCents);
        } catch (Throwable $e) {
            throw new PaymentFailedException();
        }
    }

    public function supports(PaymentProcessorType $processorType): bool
    {
        return $processorType === PaymentProcessorType::PAYPAL;
    }
}
