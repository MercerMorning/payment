<?php

namespace App\Tests\Unit\Service;

use App\Entity\Coupon;
use App\Factory\CalculateCouponDiscountedAmountStrategyFactory;
use App\Service\CalculateDiscountedAmountService;
use App\Service\CalculateTaxService;
use App\Service\CountryCodeExtractorService;
use App\Service\CountryTaxRateExtractorService;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CountryTaxRateExtractorServiceTest extends KernelTestCase
{
    /**
     * @dataProvider correctCountryTaxRates
     */
    public function testExtractWithCorrectTaxNumber(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $countryTaxRateExtractorService = $container->get(CountryTaxRateExtractorService::class);
        $result = $countryTaxRateExtractorService->extract($data['countryCode']);
        $this->assertEquals($data['percent'], $result);
    }

    public function testExtractWithIncorrectTaxNumber(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $countryTaxRateExtractorService = $container->get(CountryTaxRateExtractorService::class);
        $this->expectException(RuntimeException::class);
        $countryTaxRateExtractorService->extract('MEL');
    }


    private function correctCountryTaxRates()
    {
        return [
            [
                ['countryCode' => 'DE', 'percent' => '19'],
                ['countryCode' => 'IT', 'percent' => '22'],
                ['countryCode' => 'GR', 'percent' => '24'],
                ['countryCode' => 'FR', 'percent' => '20'],
            ]
        ];
    }
}
