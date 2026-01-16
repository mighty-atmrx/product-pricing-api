<?php

namespace App\DTO;

use App\Enum\ValidationErrorMessageEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class PriceRequestDto
{
    #[Assert\NotBlank(message: ValidationErrorMessageEnum::PRODUCT_ID_MANDATORY->value)]
    #[Assert\Type('integer', message: 'Product must be an integer')]
    #[Assert\Positive(message: ValidationErrorMessageEnum::PRODUCT_ID_MUST_BE_A_POSITIVE_INTEGER->value)]
    public $product;

    #[Assert\NotBlank(message: ValidationErrorMessageEnum::TAX_NUMBER_MANDATORY->value)]
    #[Assert\Regex(pattern: '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/', message: ValidationErrorMessageEnum::INVALID_TAX_NUMBER_PATTERN->value)]
    public $taxNumber;

    #[Assert\Type('string')]
    public $couponCode;
}
