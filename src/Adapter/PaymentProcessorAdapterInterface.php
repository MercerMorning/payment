<?php
declare(strict_types=1);

namespace App\Adapter;
interface PaymentProcessorAdapterInterface
{
    public function pay(int $price): void;
}