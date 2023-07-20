<?php

namespace App\Tests\Unit\Adaptee;

use App\Adapter\StripePaymentProcessorAdaptee;
use App\PaymentProcessor\StripePaymentProcessor;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StripePaymentProcessorAdapteeTest extends KernelTestCase
{
    public function testPayWithCorrectPrice(): void
    {
        $paymentProcessor = $this->createMock(StripePaymentProcessor::class);
        $paymentProcessor->expects(new InvokedCount(1))
            ->method('processPayment')
            ->willReturn(true);
        $paypalPaymentProcessorAdaptee = new StripePaymentProcessorAdaptee($paymentProcessor);
        $paypalPaymentProcessorAdaptee->pay(900);
    }

    public function testPayWithIncorrectPrice(): void
    {
        $paymentProcessor = $this->createMock(StripePaymentProcessor::class);
        $paymentProcessor->expects(new InvokedCount(1))
            ->method('processPayment')
            ->willReturn(false);
        $paypalPaymentProcessorAdaptee = new StripePaymentProcessorAdaptee($paymentProcessor);
        $this->expectException(InvalidArgumentException::class);
        $paypalPaymentProcessorAdaptee->pay(900);
    }
}
