<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Enum\ValidationErrorMessageEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class CalculatePriceRequest
{
    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PRODUCT_ID_MANDATORY->value)]
    #[Assert\Type('integer', message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_AN_INTEGER->value)]
    #[Assert\Positive(message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_A_POSITIVE_INTEGER->value)]
    public int $product;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::TAX_NUMBER_MANDATORY->value)]
    #[Assert\Type('string', message: ValidationErrorMessageEnum::TAX_NUMBER_MUST_BE_A_STRING->value)]
    public string $taxNumber;

    #[Assert\Type('string', message: ValidationErrorMessageEnum::COUPON_CODE_MUST_BE_A_STRING->value)]
    public string $couponCode;

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}
