<?php

namespace App\Tests\Unit\Factory;

use App\Adapter\PaypalPaymentProcessorAdaptee;
use App\Adapter\StripePaymentProcessorAdaptee;
use App\Factory\PaymentProcessorFactory;
use App\PaymentProcessor\PaypalPaymentProcessor;
use App\PaymentProcessor\StripePaymentProcessor;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaymentProcessorFactoryTest extends KernelTestCase
{
    /**
     * @return void
     * @throws \Exception@
     * @dataProvider correctPayments
     */
    public function testGetByTypeWithCorrectPurchaseData(array $data): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $paymentProcessorFactory = $container->get(PaymentProcessorFactory::class);
        $result = $paymentProcessorFactory->getByType($data['type']);
        $this->assertEquals($data['paymentClass'], $result);
    }

    public function testGetByTypeWithIncorrectPurchaseData(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $paymentProcessorFactory = $container->get(PaymentProcessorFactory::class);
        $this->expectException(RuntimeException::class);
        $paymentProcessorFactory->getByType('cash');
    }

    private function correctPayments(): array
    {
        return [
            [
                ['type' => 'stripe', 'paymentClass' => new StripePaymentProcessorAdaptee(new StripePaymentProcessor())],
                ['type' => 'paypal', 'paymentClass' => new PaypalPaymentProcessorAdaptee(new PaypalPaymentProcessor())],
            ]
        ];
    }
}
