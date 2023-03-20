<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use App\Entity\ProductType;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testEntity()
    {
        $id = 2;
        $name = 'foo';
        $type = (new ProductType())->setName('foo2');
        $tst1 = new Product();
        $tst1->setId($id);
        $tst1->setName($name);
        $tst1->setType($type);
        $this->assertEquals($id, $tst1->getId());
        $this->assertEquals($name, $tst1->getName());
        $this->assertEquals($type, $tst1->getType());
    }
}
