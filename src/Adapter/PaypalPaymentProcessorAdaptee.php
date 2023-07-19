<?php
declare(strict_types=1);

namespace App\Adapter;

use App\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentProcessorAdaptee implements PaymentProcessorAdapterInterface
{
    private PaypalPaymentProcessor $object;

    /**
     * @param PaypalPaymentProcessor $object
     */
    public function __construct(PaypalPaymentProcessor $object)
    {
        $this->object = $object;
    }


    public function pay(int $price): void
    {
        $this->object->pay($price);
    }
}