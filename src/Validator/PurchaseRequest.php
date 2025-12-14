<?php

namespace App\Validator;

use App\Enum\ValidationErrorMessageEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest
{
    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PRODUCT_ID_MANDATORY->value)]
    #[Assert\Type('integer', message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_AN_INTEGER->value)]
    #[Assert\Positive(message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_A_POSITIVE_INTEGER->value)]
    public ?int $product = null;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::TAX_NUMBER_MANDATORY->value)]
    #[Assert\Type('string', message: ValidationErrorMessageEnum::TAX_NUMBER_MUST_BE_A_STRING->value)]
    #[Assert\Regex(pattern: '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/', message: ValidationErrorMessageEnum::INVALID_TAX_NUMBER_PATTERN->value)]
    private ?string $taxNumber = null;

    #[Assert\Type('string', message: ValidationErrorMessageEnum::COUPON_CODE_MUST_BE_A_STRING->value)]
    private ?string $couponCode = null;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PAYMENT_PROCESSOR_MANDATORY->value)]
    #[Assert\Type('string', message: ValidationErrorMessageEnum::PAYMENT_PROCESSOR_MUST_BE_A_STRING->value)]
    #[Assert\Choice(['paypal', 'stripe'])]
    private string $paymentProcessor;
}
