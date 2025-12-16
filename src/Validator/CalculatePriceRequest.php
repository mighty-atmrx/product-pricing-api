<?php

namespace App\Validator;

use App\Enum\ValidationErrorMessageEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class CalculatePriceRequest
{
    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PRODUCT_ID_MANDATORY->value)]
    #[Assert\Type('integer', message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_AN_INTEGER->value)]
    #[Assert\Positive(message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_A_POSITIVE_INTEGER->value)]
    public ?int $product = null;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::TAX_NUMBER_MANDATORY->value)]
    #[Assert\Type('string', message: ValidationErrorMessageEnum::TAX_NUMBER_MUST_BE_A_STRING->value)]
    #[Assert\Regex(pattern: '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/', message: ValidationErrorMessageEnum::INVALID_TAX_NUMBER_PATTERN->value)]
    public ?string $taxNumber = null;

    #[Assert\Type('string', message: ValidationErrorMessageEnum::COUPON_CODE_MUST_BE_A_STRING->value)]
    public ?string $couponCode = null;

    public function getProduct(): ?int
    {
        return $this->product;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }
}
