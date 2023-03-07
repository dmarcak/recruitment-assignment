<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Index(columns: ['created_at'])]
class Product implements \App\Service\Catalog\Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $priceAmount;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(string $id, string $name, int $price, DateTimeImmutable $createdAt)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
        $this->priceAmount = $price;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(int $price): void
    {
        $this->priceAmount = $price;
    }

    public function getPrice(): int
    {
        return $this->priceAmount;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function equals(Product $product): bool
    {
        return $this->id->equals($product->id);
    }
}
