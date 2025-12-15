<?php

namespace App\Payment;

use App\Exception\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Psr\Log\LoggerInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

readonly class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paymentProcessor,
        private LoggerInterface $logger
    ) {
    }

    public function pay(float $amount): void
    {
        $amountInCents = (int) round($amount * 100);
        try {
            $this->paymentProcessor->pay($amountInCents);
        } catch (Throwable $e) {
            $this->logger->error('Paypal payment failed', ['amount' => $amount, 'exception' => $e]);
            throw new PaymentFailedException();
        }
    }
}
