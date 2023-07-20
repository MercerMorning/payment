<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Factory\CalculateCouponDiscountedAmountStrategyFactory;

class CalculateDiscountedAmountService
{
    private CalculateCouponDiscountedAmountStrategyFactory $calculateCouponDiscountStrategyFactory;

    /**
     * @param CalculateCouponDiscountedAmountStrategyFactory $calculateCouponDiscountStrategyFactory
     */
    public function __construct(CalculateCouponDiscountedAmountStrategyFactory $calculateCouponDiscountStrategyFactory)
    {
        $this->calculateCouponDiscountStrategyFactory = $calculateCouponDiscountStrategyFactory;
    }


    public function calculate(float $amount, Coupon $coupon) :float
    {
        return $this->calculateCouponDiscountStrategyFactory
            ->getByType($coupon->getType())
            ->calculate($amount, $coupon->getValue());
    }
}