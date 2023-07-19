<?php
declare(strict_types=1);


namespace App\Strategy;


interface CalculateCouponDiscountStrategyInterface
{
    public function calculate(float $amount, float $discountValue): float;
}