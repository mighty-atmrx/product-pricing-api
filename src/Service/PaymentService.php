<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CalculatePriceInputDto;
use App\Enum\PaymentProcessorType;
use App\Exception\PaymentFailedException;
use App\Exception\PaymentProcessorNotFoundException;
use App\Service\Payment\PaymentProcessorResolver;
use Psr\Log\LoggerInterface;

readonly class PaymentService
{
    public function __construct(
        private LoggerInterface $logger,
        private PaymentProcessorResolver $resolver,
        private PriceCalculatorService $priceCalculatorService
    ){
    }

    /**
     * @throws PaymentProcessorNotFoundException
     * @throws PaymentFailedException
     */
    public function payment(PaymentProcessorType $processorType, CalculatePriceInputDto $dto): void
    {
        $priceDto = $this->priceCalculatorService->calculate($dto);
        $price = $priceDto->getFinalPrice();

        $this->logger->info('Payment started', ['processorType' => $processorType->value, 'amount' => $price]);

        try {
            $this->resolver->getProcessor($processorType)->pay($price);
            $this->logger->info('Payment completed', ['processorType' => $processorType->value, 'amount' => $price]);
        } catch (PaymentProcessorNotFoundException $e) {
            $this->logger->error('Payment processor not found', ['processorType' => $processorType->value]);
            throw $e;
        } catch (PaymentFailedException $e) {
            $this->logger->error('Payment failed', ['processorType' => $processorType->value, 'amount' => $price, 'error' => $e]);
            throw $e;
        }

    }
}
