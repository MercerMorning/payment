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

class CountryCodeExtractorServiceTest extends KernelTestCase
{
    /**
     * @dataProvider correctTaxes
     */
    public function testExtractWithCorrectTaxNumber(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $countryCodeExtractorService = $container->get(CountryCodeExtractorService::class);
        $result = $countryCodeExtractorService->extract($data['taxNumber']);
        $this->assertEquals($data['taxCode'], $result);
    }

    public function testExtractWithIncorrectTaxNumber(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $countryCodeExtractorService = $container->get(CountryCodeExtractorService::class);
        $this->expectException(RuntimeException::class);
        $countryCodeExtractorService->extract('DE111111111R');
    }


    private function correctTaxes()
    {
        return [
            [
                ['taxNumber' => 'DE111111111', 'taxCode' => 'DE'],
                ['taxNumber' => 'IT1111111111', 'taxCode' => 'IT'],
                ['taxNumber' => 'GR111111111', 'taxCode' => 'GR'],
                ['taxNumber' => 'FRER111111111', 'taxCode' => 'FR'],
            ]
        ];
    }
}
