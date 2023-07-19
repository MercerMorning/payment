<?php
declare(strict_types=1);

namespace App\Service;

use RuntimeException;

class CountryCodeExtractorService
{
    private array $taxNumberRegexCountryCode = [];

    public function addTaxNumberRegexCountry(string $regex, string $countryCode)
    {
        $this->taxNumberRegexCountryCode[$regex] = $countryCode;
    }

    public function extract(string $taxNumber): string
    {
        foreach ($this->taxNumberRegexCountryCode as $regex => $countryCode) {
            if (preg_match($regex, $taxNumber)) {
                return $countryCode;
            }
        }
        throw new RuntimeException(
            'Country code for tax number:' . $taxNumber . ' does not exist'
        );
    }
}