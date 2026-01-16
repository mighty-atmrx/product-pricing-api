<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentProcessorTypeEnum;
use App\Exception\PaymentFailedException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

readonly class PaypalPaymentAdapter implements PaymentAdapterInterface
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

    public function supports(PaymentProcessorTypeEnum $processorType): bool
    {
        return $processorType === PaymentProcessorTypeEnum::PAYPAL;
    }
}
