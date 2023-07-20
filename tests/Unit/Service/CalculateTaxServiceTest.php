<?php

namespace App\Tests\Unit\Service;

use App\Service\CalculateTaxService;
use App\Service\CountryCodeExtractorService;
use App\Service\CountryTaxRateExtractorService;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateTaxServiceTest extends KernelTestCase
{
    /**
     * @dataProvider correctTaxes
     */
    public function testCalculateWithCorrectTaxNumber(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $calculateTaxService = new CalculateTaxService(
            $container->get(CountryCodeExtractorService::class),
            $container->get(CountryTaxRateExtractorService::class),
        );
        $result = $calculateTaxService->calculate($data['amount'], $data['taxNumber']);
        $this->assertSame($data['tax'], $result);
    }

    public function testCalculateWithIncorrectTaxNumber(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $calculateTaxService = new CalculateTaxService(
            $container->get(CountryCodeExtractorService::class),
            $container->get(CountryTaxRateExtractorService::class),
        );
        $this->expectException(RuntimeException::class);
        $calculateTaxService->calculate(100, 'BR333');
    }


    private function correctTaxes()
    {
        return [
            [
                ['taxNumber' => 'DE111111111', 'amount' => 100, 'tax' => 19.0],
                ['taxNumber' => 'IT1111111111', 'amount' => 100, 'tax' => 22.0],
                ['taxNumber' => 'GR111111111', 'amount' => 100, 'tax' => 24.0],
                ['taxNumber' => 'FRER111111111', 'amount' => 100, 'tax' => 20.0],
            ]
        ];
    }
}
