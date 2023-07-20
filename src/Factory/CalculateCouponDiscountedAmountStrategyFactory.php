<?php
declare(strict_types=1);

namespace App\Factory;

use App\Strategy\CalculateCouponDiscountStrategyInterface;
use RuntimeException;

class CalculateCouponDiscountedAmountStrategyFactory
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
            throw new RuntimeException('Strategy for ' . $type . ' does not exist');
        }
        return $this->typeCalculateCouponDiscountStrategies[$type];
    }
}