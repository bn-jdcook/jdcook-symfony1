<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Link;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
class ProductType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /** @var Product[] */
    #[Link(toProperty: 'type')]
    public array $products = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     * @return ProductType
     */
    public function setProducts(array $products): ProductType
    {
        $this->products = $products;
        return $this;
    }
}
