<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addProduct(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
