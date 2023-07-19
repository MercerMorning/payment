<?php
declare(strict_types=1);

namespace App\Factory;

use App\Adapter\PaymentProcessorAdapterInterface;
use RuntimeException;

class PaymentProcessorFactory
{
    private array $typePaymentProcessor = [];

    public function addTypePaymentProcessor(string $type, PaymentProcessorAdapterInterface $paymentProcessor)
    {
        $this->typePaymentProcessor[$type] = $paymentProcessor;
    }

    public function getByType(string $type) :PaymentProcessorAdapterInterface
    {
        if (!isset($this->typePaymentProcessor[$type])) {
            throw new RuntimeException('Processor for ' . $type . ' does not exist');
        }
        return $this->typePaymentProcessor[$type];
    }
}