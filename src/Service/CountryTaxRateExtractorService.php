<?php
declare(strict_types=1);

namespace App\Service;

use RuntimeException;

class CountryTaxRateExtractorService
{
    private array $countryCodeTaxRates = [];

    public function addCountryTaxRate(string $countryCode, float $rate)
    {
        $this->countryCodeTaxRates[$countryCode] = $rate;
    }

    public function extract(string $countryCode): float
    {
        if (!isset($this->countryCodeTaxRates[$countryCode])) {
            throw new RuntimeException(
                'Tax rate for country code:' . $countryCode . ' does not exist'
            );
        }
        return $this->countryCodeTaxRates[$countryCode];
    }
}