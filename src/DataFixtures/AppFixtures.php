<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productType1 = (new ProductType())->setName('type1');
        $manager->persist($productType1);
        $productType2 = (new ProductType())->setName('type2');
        $manager->persist($productType2);

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product ' . $i);
            $product->setType(
                $i % 3 == 0 ?
                    $productType2 : $productType1
            );
            $manager->persist($product);
        }

        $manager->flush();
    }
}
