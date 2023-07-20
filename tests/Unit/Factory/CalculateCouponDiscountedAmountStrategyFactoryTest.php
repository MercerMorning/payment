<?php

namespace App\Tests\Unit\Factory;

use App\Factory\CalculateCouponDiscountedAmountStrategyFactory;
use App\Strategy\CalculateFixedCouponDiscountedAmountStrategy;
use App\Strategy\CalculatePercentCouponDiscountedAmountStrategy;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateCouponDiscountedAmountStrategyFactoryTest extends KernelTestCase
{
    /**
     * @return void
     * @throws \Exception@
     * @dataProvider correctDiscounts
     */
    public function testGetByTypeWithCorrectDiscountType(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $paymentProcessorFactory = $container->get(CalculateCouponDiscountedAmountStrategyFactory::class);
        $result = $paymentProcessorFactory->getByType($data['type']);
        $this->assertEquals($data['calculateClass'], $result);
    }

    public function testGetByTypeWithIncorrectDiscountType(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $paymentProcessorFactory = $container->get(CalculateCouponDiscountedAmountStrategyFactory::class);
        $this->expectException(RuntimeException::class);
        $paymentProcessorFactory->getByType('test');
    }

    private function correctDiscounts(): array
    {
        return [
            [
                ['type' => 'fixed', 'calculateClass' => new CalculateFixedCouponDiscountedAmountStrategy()],
                ['type' => 'percent', 'calculateClass' => new CalculatePercentCouponDiscountedAmountStrategy()],
            ]
        ];
    }
}
