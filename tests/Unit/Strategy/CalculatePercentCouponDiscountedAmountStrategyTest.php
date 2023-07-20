<?php

namespace App\Tests\Unit\Strategy;

use App\Strategy\CalculatePercentCouponDiscountedAmountStrategy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatePercentCouponDiscountedAmountStrategyTest extends KernelTestCase
{
    /**
     * @dataProvider correctDiscounts
     */
    public function testCalculateWithCorrectDiscount(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $calculateFixedCouponDiscountedAmountStrategy =
            $container->get(CalculatePercentCouponDiscountedAmountStrategy::class);
        $result = $calculateFixedCouponDiscountedAmountStrategy
            ->calculate($data['originalAmount'], $data['discount']);
        $this->assertEquals($data['discountedAmount'], $result);
    }

    private function correctDiscounts()
    {
        return [
            [
                ['originalAmount' => '100', 'discount' => '20', 'discountedAmount' => 80.0],
                ['originalAmount' => '70', 'discount' => '20', 'discountedAmount' => 56.0],
            ]
        ];
    }
}
