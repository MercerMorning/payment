<?php
declare(strict_types=1);

namespace App\Strategy;

class CalculatePercentCouponDiscountStrategy implements CalculateCouponDiscountStrategyInterface
{

    public function calculate(float $amount, float $discountValue): float
    {
        return $amount - ($amount/100 * $discountValue);
    }
}