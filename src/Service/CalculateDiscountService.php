<?php
declare(strict_types=1);


namespace App\Service;


use App\Entity\Coupon;
use App\Entity\Product;
use App\Factory\CalculateCouponDiscountStrategyFactory;

class CalculateDiscountService
{
    private CalculateCouponDiscountStrategyFactory $calculateCouponDiscountStrategyFactory;

    /**
     * @param CalculateCouponDiscountStrategyFactory $calculateCouponDiscountStrategyFactory
     */
    public function __construct(CalculateCouponDiscountStrategyFactory $calculateCouponDiscountStrategyFactory)
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