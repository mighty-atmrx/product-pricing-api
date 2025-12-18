<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\Country;

readonly class TaxNumberService
{
    public function getTaxRate(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);
        return Country::fromCode($countryCode)->taxRate();
    }
}
