<?php
declare(strict_types=1);

namespace App\Enum;

enum PaymentProcessor
{
    case Paypal;

    case Stripe;
}