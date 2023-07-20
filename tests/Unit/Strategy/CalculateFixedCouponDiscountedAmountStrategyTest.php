<?php

namespace App\Tests\Unit\Strategy;

use App\Entity\Coupon;
use App\Factory\CalculateCouponDiscountedAmountStrategyFactory;
use App\Service\CalculateDiscountedAmountService;
use App\Service\CalculateTaxService;
use App\Service\CountryCodeExtractorService;
use App\Service\CountryTaxRateExtractorService;
use App\Strategy\CalculateFixedCouponDiscountedAmountStrategy;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateFixedCouponDiscountedAmountStrategyTest extends KernelTestCase
{
    /**
     * @dataProvider correctDiscounts
     */
    public function testCalculateWithCorrectDiscount(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $calculateFixedCouponDiscountedAmountStrategy =
            $container->get(CalculateFixedCouponDiscountedAmountStrategy::class);
        $result = $calculateFixedCouponDiscountedAmountStrategy
            ->calculate($data['originalAmount'], $data['discount']);
        $this->assertEquals($data['discountedAmount'], $result);
    }

    public function testCalculateWithDiscountMoreThanAmount(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $calculateFixedCouponDiscountedAmountStrategy =
            $container->get(CalculateFixedCouponDiscountedAmountStrategy::class);
        $this->expectException(InvalidArgumentException::class);
        $calculateFixedCouponDiscountedAmountStrategy
            ->calculate(100, 101);
    }


    private function correctDiscounts()
    {
        return [
            [
                ['originalAmount' => '100', 'discount' => '20', 'discountedAmount' => 80.0],
                ['originalAmount' => '70', 'discount' => '20', 'discountedAmount' => 50.0],
            ]
        ];
    }
}
