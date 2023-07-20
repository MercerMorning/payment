<?php

namespace App\Tests\Unit\Service;

use App\Entity\Coupon;
use App\Factory\CalculateCouponDiscountedAmountStrategyFactory;
use App\Service\CalculateDiscountedAmountService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateDiscountedAmountServiceTest extends KernelTestCase
{
    /**
     * @dataProvider correctCoupons
     */
    public function testCalculateWithCorrectCoupon(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $factory = $container->get(CalculateCouponDiscountedAmountStrategyFactory::class);
        $calculateDiscountService = new CalculateDiscountedAmountService($factory);
        $result = $calculateDiscountService->calculate($data['originalAmount'], $data['coupon']);
        $this->assertSame($data['discountAmount'], $result);
    }

    public function testCalculateWithDiscountMoreThanAmount(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $fact = $container->get(CalculateCouponDiscountedAmountStrategyFactory::class);
        $calculateDiscountService = new CalculateDiscountedAmountService($fact);
        $fixed = (new Coupon())->setType('fixed')->setCode('D1')->setValue('101');
        $this->expectException(InvalidArgumentException::class);
        $calculateDiscountService->calculate(100, $fixed);
    }

    private function correctCoupons()
    {
        $fixed = (new Coupon())->setType('fixed')->setCode('D1')->setValue('10');
        $percent = (new Coupon())->setType('percent')->setCode('D1')->setValue('20');
        return [
            [
                'fixed' => [ 'coupon' => $fixed, 'originalAmount' => 100, 'discountAmount' => 90.0],
                'percent' => [ 'coupon' => $percent, 'originalAmount' => 120, 'discountAmount' => 96.0],
            ]
        ];
    }
}
