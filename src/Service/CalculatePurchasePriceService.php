<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\PurchaseDTO;
use App\Factory\PaymentProcessorFactory;
use App\Manager\CouponManager;
use App\Manager\ProductManager;

class CalculatePurchasePriceService
{
    private ProductManager $productManager;
    private CouponManager $couponManager;
    private PaymentProcessorFactory $paymentProcessorFactory;
    private CalculateDiscountService $discountCalculateService;
    private CalculateTaxService $taxCalculateService;

    /**
     * @param ProductManager $productManager
     * @param CouponManager $couponManager
     * @param PaymentProcessorFactory $paymentProcessorFactory
     * @param CalculateDiscountService $discountCalculateService
     * @param CalculateTaxService $taxCalculateService
     */
    public function __construct(
        ProductManager           $productManager,
        CouponManager            $couponManager,
        PaymentProcessorFactory  $paymentProcessorFactory,
        CalculateDiscountService $discountCalculateService,
        CalculateTaxService $taxCalculateService
    )
    {
        $this->productManager = $productManager;
        $this->couponManager = $couponManager;
        $this->paymentProcessorFactory = $paymentProcessorFactory;
        $this->discountCalculateService = $discountCalculateService;
        $this->taxCalculateService = $taxCalculateService;
    }


    public function calculate(PurchaseDTO $purchase) :float
    {
        $product = $this->productManager->getProductById((int) $purchase->product);
        $amount = $this->taxCalculateService->calculate(
            $product->getPrice(),
            $purchase->taxNumber
        );
        if ($purchase->couponCode !== null) {
            $coupon = $this->couponManager->getCouponByCode($purchase->couponCode);
            $amount = $this->discountCalculateService->calculate($amount, $coupon);
        }
        return $amount;
    }
}