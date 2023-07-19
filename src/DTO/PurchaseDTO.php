<?php
declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class PurchaseDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $product = '',

        #[Assert\NotBlank]
        #[Assert\AtLeastOneOf([
            new Assert\Regex('#^DE\d{9}$#'),
            new Assert\Regex('#^IT\d{10}$#'),
            new Assert\Regex('#^GR\d{9}$#'),
            new Assert\Regex('#^FR[a-zA-Z]{2}\d{9}$#'),
        ])]
        public string $taxNumber = '',

        public ?string $couponCode = null,

        #[Assert\Choice(['paypal', 'stripe'])]
        public string $paymentProcessor = '',
    ) {
    }
}