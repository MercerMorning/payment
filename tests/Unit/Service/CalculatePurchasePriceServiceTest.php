<?php

namespace App\Tests\Unit\Service;

use App\DTO\PurchaseDTO;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Manager\CouponManager;
use App\Manager\ProductManager;
use App\Service\CalculatePurchasePriceService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatePurchasePriceServiceTest extends KernelTestCase
{
    /**
     * @return void
     * @throws \Exception@
     * @dataProvider correctPurchases
     */
    public function testCalculateWithCorrectPurchaseData(PurchaseDTO $purchase): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $productManager = $this->createMock(ProductManager::class);
        $productManager->method('getProductById')
            ->willReturn((new Product())->setName('iphone')->setPrice(100));
        $couponManager = $this->createMock(CouponManager::class);
        $couponManager->method('getCouponByCode')
            ->willReturn((new Coupon())->setCode('D2')->setType('fixed')->setValue(10));
        $container->set(ProductManager::class, $productManager);
        $container->set(CouponManager::class, $couponManager);
        $calculatePurchasePriceService = $container->get(CalculatePurchasePriceService::class);
        $result = $calculatePurchasePriceService->calculate(
            $purchase
        );
        $this->assertSame(109.0, $result);
    }

    private function correctPurchases(): array
    {
        return [
            [
                new PurchaseDTO('1', 'DE111111111', 'D2', 'stripe'),
                new PurchaseDTO('1', 'DE111111111', 'D2', 'paypal'),
            ]
        ];
    }
}
