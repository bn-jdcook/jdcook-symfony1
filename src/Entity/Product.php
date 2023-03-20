<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity]
#[ApiResource(
    uriTemplate: '/product_types/{typeId}/products',
    operations: [ new GetCollection() ],
    uriVariables: [
        'typeId' => new Link(toProperty: 'type', fromClass: ProductType::class),
    ]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: ProductType::class)]
    private ?ProductType $type;

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

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
     * @return ProductType|null
     */
    public function getType(): ?ProductType
    {
        return $this->type;
    }

    /**
     * @param ProductType|null $type
     * @return Product
     */
    public function setType(?ProductType $type): Product
    {
        $this->type = $type;
        return $this;
    }

}
