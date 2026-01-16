<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\CountryEnum;

readonly class TaxNumberService
{
    public function getTaxRate(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);
        return CountryEnum::fromCode($countryCode)->taxRate();
    }
}
