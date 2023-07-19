<?php
declare(strict_types=1);


namespace App\Strategy;


class CalculateFixedCouponDiscountStrategy implements CalculateCouponDiscountStrategyInterface
{
    public function calculate(float $amount, float $discountValue): float
    {
        $result = $amount - $discountValue;
        if ($result < 0) {
            throw new \Exception('Amount below a zero');
        }
        return $result;
    }
}