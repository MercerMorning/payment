<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\PurchaseDTO;
use App\Factory\PaymentProcessorFactory;
use App\Manager\CouponManager;
use App\Manager\ProductManager;
use Doctrine\ORM\EntityNotFoundException;

class CalculatePurchasePriceService
{
    private ProductManager $productManager;
    private CouponManager $couponManager;
    private CalculateDiscountedAmountService $discountedAmountCalculateService;
    private CalculateTaxService $taxCalculateService;

    /**
     * @param ProductManager $productManager
     * @param CouponManager $couponManager
     * @param PaymentProcessorFactory $paymentProcessorFactory
     * @param CalculateDiscountedAmountService $discountCalculateService
     * @param CalculateTaxService $taxCalculateService
     */
    public function __construct(
        ProductManager                   $productManager,
        CouponManager                    $couponManager,
        PaymentProcessorFactory          $paymentProcessorFactory,
        CalculateDiscountedAmountService $discountCalculateService,
        CalculateTaxService              $taxCalculateService
    )
    {
        $this->productManager = $productManager;
        $this->couponManager = $couponManager;
        $this->paymentProcessorFactory = $paymentProcessorFactory;
        $this->discountedAmountCalculateService = $discountCalculateService;
        $this->taxCalculateService = $taxCalculateService;
    }


    /**
     * @throws EntityNotFoundException
     */
    public function calculate(PurchaseDTO $purchase) :float
    {
        $product = $this->productManager->getProductById((int) $purchase->product);
        $amount = $product->getPrice() + $this->taxCalculateService->calculate(
            $product->getPrice(),
            $purchase->taxNumber
        );
        if ($purchase->couponCode !== null) {
            $coupon = $this->couponManager->getCouponByCode($purchase->couponCode);
            $amount = $this->discountedAmountCalculateService->calculate($amount, $coupon);
        }
        return $amount;
    }
}