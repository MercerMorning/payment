<?php

namespace App\Tests\Api\v1;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PurchasePostTest extends ApiTestCase
{
    /**
     * @dataProvider correctCoupons
     */
    public function testWithCorrectCoupon(array $purchaseData): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'couponCode' => $purchaseData['couponCode'],
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonEquals([
            'message' => 'ok'
        ]);
    }

    public function testWithIncorrectCoupon(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'couponCode' => 'D17',
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonEquals([
            'message' => 'fail',
            'errors' => [
                'Coupon with code: D17 not found'
            ]
        ]);
    }

    public function testWithoutCoupon(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonEquals([
            'message' => 'ok'
        ]);
    }

    /**
     * @dataProvider correctTaxNumbers
     */
    public function testWithCorrectTaxNumber(array $purchaseData): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => $purchaseData['taxNumber'],
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonEquals([
            'message' => 'ok'
        ]);
    }

    public function testWithIncorrectTaxNumber(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR11111111D',
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonEquals([
            'message' => 'fail',
            'errors' => [
                "taxNumber" => [
                    'This value should satisfy at least one of the following constraints: [1] This value is not valid. [2] This value is not valid. [3] This value is not valid. [4] This value is not valid.'
                ]
            ]
        ]);
    }

    public function testWithCorrectProduct(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonEquals([
            'message' => 'ok'
        ]);
    }

    public function testWithIncorrectProduct(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '33',
                        'taxNumber' => 'GR111111111',
                        'paymentProcessor' => 'stripe'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonEquals([
            'message' => 'fail',
            'errors' => [
                'Product with id: 33 not found'
            ]
        ]);
    }

    /**
     * @dataProvider correctPayments
     */
    public function testWithCorrectPayment(string $payment): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'paymentProcessor' => $payment
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonEquals([
            'message' => 'ok'
        ]);
    }

    public function testWithIncorrectPayment(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/purchase',
            [
                'json' =>
                    [
                        'product' => '1',
                        'taxNumber' => 'GR111111111',
                        'paymentProcessor' => 'cash'
                    ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonEquals([
            'message' => 'fail',
            'errors' => [
                'paymentProcessor' => [
                    'The value you selected is not a valid choice.'
                ]
            ]
        ]);
    }

    private function correctPayments()
    {
        return [
            [
                'stripe',
                'paypal'
            ]
        ];
    }
    private function correctCoupons()
    {
        return [
            [
                ['couponCode' => 'D15', 'amount' => 116.56],
                ['couponCode' => 'D16', 'amount' => 89],
            ]
        ];
    }

    private function correctTaxNumbers()
    {
        return [
            [
                ['taxNumber' => 'DE111111111', 'amount' => 119],
                ['taxNumber' => 'IT1111111111', 'amount' => 122],
                ['taxNumber' => 'GR111111111', 'amount' => 124],
                ['taxNumber' => 'FRER111111111', 'amount' => 120],
            ]
        ];
    }
}
