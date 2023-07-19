<?php
declare(strict_types=1);

namespace App\Adapter;

use App\PaymentProcessor\StripePaymentProcessor;

class StripePaymentProcessorAdaptee implements PaymentProcessorAdapterInterface
{
    private StripePaymentProcessor $object;

    /**
     * @param StripePaymentProcessor $object
     */
    public function __construct(StripePaymentProcessor $object)
    {
        $this->object = $object;
    }


    public function pay(int $price): void
    {
        $succeed = $this->object->processPayment($price);
        if (!$succeed) {
            throw new \Exception('Too low price');
        }
    }
}