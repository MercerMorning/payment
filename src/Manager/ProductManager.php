<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class ProductManager
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getProductById(int $id) :Product
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->entityManager->getRepository(Product::class);
        $product = $productRepository->find($id);
        if ($product === null) {
            throw new EntityNotFoundException('Product with id: ' . $id . ' not found');
        }
        return $productRepository->find($id);
    }
}