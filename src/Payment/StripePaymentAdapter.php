<?php

namespace App\Payment;

use App\Exception\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Psr\Log\LoggerInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private StripePaymentProcessor $paymentProcessor,
        private LoggerInterface $logger
    ) {
    }

    public function pay(float $amount): void
    {
        if (!$this->paymentProcessor->processPayment($amount)) {
            $this->logger->error('Stripe payment failed', ['amount' => $amount]);
            throw new PaymentFailedException();
        }
    }
}
