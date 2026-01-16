<?php

namespace App\Enum;

enum ValidationErrorMessageEnum: string
{
    case PRODUCT_ID_MANDATORY = 'product_id_is_mandatory';
    case PRODUCT_ID_MUST_BE_AN_INTEGER = 'product_id_must_be_an_integer';
    case PRODUCT_ID_MUST_BE_A_POSITIVE_INTEGER = 'product_id_must_be_a_positive_integer';

    case TAX_NUMBER_MANDATORY = 'tax_number_is_mandatory';

    case PAYMENT_PROCESSOR_MANDATORY = 'payment_processor_mandatory';
    case PAYMENT_PROCESSOR_MUST_BE_A_STRING = 'payment_processor_must_be_a_string';

    case INVALID_TAX_NUMBER_PATTERN = 'invalid_tax_number_pattern';
}
