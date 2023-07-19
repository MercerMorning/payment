<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\PurchaseDTO;
use App\Factory\PaymentProcessorFactory;

class MakePurchasePriceService
{
    private readonly CalculatePurchasePriceService $calculatePurchasePriceService;
    private readonly PaymentProcessorFactory $paymentProcessorFactory;

    /**
     * @param CalculatePurchasePriceService $calculatePurchasePriceService
     * @param PaymentProcessorFactory $paymentProcessorFactory
     */
    public function __construct(CalculatePurchasePriceService $calculatePurchasePriceService, PaymentProcessorFactory $paymentProcessorFactory)
    {
        $this->calculatePurchasePriceService = $calculatePurchasePriceService;
        $this->paymentProcessorFactory = $paymentProcessorFactory;
    }


    public function make(PurchaseDTO $purchase) :void
    {
        $amount = $this->calculatePurchasePriceService->calculate($purchase);
        $this->paymentProcessorFactory
            ->getByType($purchase->paymentProcessor)
            ->pay((int) $amount);
    }
}