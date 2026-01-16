<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\DTO\PriceRequestDto;
use App\Enum\PaymentProcessorTypeEnum;
use App\Enum\ValidationErrorMessageEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest
{
    #[Assert\NotNull]
    #[Assert\Valid]
    public PriceRequestDto $price;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PAYMENT_PROCESSOR_MANDATORY->value)]
    #[Assert\Type('string', message: ValidationErrorMessageEnum::PAYMENT_PROCESSOR_MUST_BE_A_STRING->value)]
    #[Assert\Choice(callback: [PaymentProcessorTypeEnum::class, 'values'])]
    public string $paymentProcessor;

    public function getPaymentProcessorAsEnum(): PaymentProcessorTypeEnum
    {
        return PaymentProcessorTypeEnum::from($this->paymentProcessor);
    }
}
