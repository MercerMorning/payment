<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Coupon;
use App\Repository\CouponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class CouponManager
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCouponByCode(string $code) :Coupon
    {
        /** @var CouponRepository $couponRepository */
        $couponRepository = $this->entityManager->getRepository(Coupon::class);
        $coupon = $couponRepository->findOneByCode($code);
        if ($coupon === null) {
            throw new EntityNotFoundException('Coupon with code: ' . $code . ' not found');
        }
        return $coupon;
    }
}