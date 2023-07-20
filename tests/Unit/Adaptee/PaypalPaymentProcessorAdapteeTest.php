<?php

namespace App\Tests\Unit\Adaptee;

use App\Adapter\PaypalPaymentProcessorAdaptee;
use App\Adapter\StripePaymentProcessorAdaptee;
use App\Factory\PaymentProcessorFactory;
use App\PaymentProcessor\PaypalPaymentProcessor;
use App\PaymentProcessor\StripePaymentProcessor;
use Exception;
use PHPUnit\Framework\MockObject\Rule\InvokedAtLeastOnce;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaypalPaymentProcessorAdapteeTest extends KernelTestCase
{
    public function testPayWithCorrectPrice(): void
    {
        $paymentProcessor = $this->createMock(PaypalPaymentProcessor::class);
        $paymentProcessor->expects(new InvokedCount(1))->method('pay');
        $paypalPaymentProcessorAdaptee = new PaypalPaymentProcessorAdaptee($paymentProcessor);
        $paypalPaymentProcessorAdaptee->pay(90);
    }
}
