<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

class CalculateTaxService
{
    private CountryCodeExtractorService $countryExtractorService;
    private CountryTaxRateExtractorService $countryTaxRateExtractorService;

    /**
     * @param CountryCodeExtractorService $countryExtractorService
     * @param CountryTaxRateExtractorService $countryTaxRateExtractorService
     */
    public function __construct(CountryCodeExtractorService $countryExtractorService, CountryTaxRateExtractorService $countryTaxRateExtractorService)
    {
        $this->countryExtractorService = $countryExtractorService;
        $this->countryTaxRateExtractorService = $countryTaxRateExtractorService;
    }

    public function calculate(float $amount, string $taxNumber) : float
    {
        $countryCode = $this->countryExtractorService->extract($taxNumber);
        $taxRate = $this->countryTaxRateExtractorService->extract($countryCode);
        return $amount + ($amount / 100 * $taxRate);
    }
}