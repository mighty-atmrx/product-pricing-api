<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;
use App\Exception\PaymentProcessorNotFoundException;
use App\Payment\PaymentProcessorResolver;
use Psr\Log\LoggerInterface;

readonly class PaymentService
{
    public function __construct(
        private LoggerInterface $logger,
        private PaymentProcessorResolver $resolver
    ){
    }

    /**
     * @throws PaymentProcessorNotFoundException
     * @throws PaymentFailedException
     */
    public function payment(PaymentProcessorType $processorType, float $amount): void
    {
        try {
            $this->logger->info('Payment started', ['processorType' => $processorType->value, 'amount' => $amount]);
            $this->resolver->getProcessor($processorType)->pay($amount);
            $this->logger->info('Payment completed', ['processorType' => $processorType->value, 'amount' => $amount]);
        } catch (PaymentProcessorNotFoundException $e) {
            $this->logger->error('Payment processor not found', ['processorType' => $processorType->value]);
            throw $e;
        }catch (PaymentFailedException $e) {
            $this->logger->error('Payment failed', ['processorType' => $processorType->value, 'amount' => $amount, 'error' => $e]);
            throw $e;
        }

    }
}
