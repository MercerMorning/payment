<?php
declare(strict_types=1);

namespace App\Factory;

use App\Adapter\PaymentProcessorAdapterInterface;
use App\Strategy\CalculateCouponDiscountStrategyInterface;

class CalculateCouponDiscountStrategyFactory
{
    private array $typeCalculateCouponDiscountStrategies = [];

    public function addCalculateCouponDiscountStrategy(
        string                                   $type,
        CalculateCouponDiscountStrategyInterface $strategy
    )
    {
        $this->typeCalculateCouponDiscountStrategies[$type] = $strategy;
    }

    public function getByType(string $type): CalculateCouponDiscountStrategyInterface
    {
        if (!isset($this->typeCalculateCouponDiscountStrategies[$type])) {
            throw new \Exception('Strategy for ' . $type . ' does not exist');
        }
        return $this->typeCalculateCouponDiscountStrategies[$type];
    }
}