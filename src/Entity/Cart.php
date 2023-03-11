<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    /** @var Collection<int, CartProduct> */
    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartProduct::class, cascade: [
        'persist',
        'remove'
    ], orphanRemoval: true)]
    private Collection $products;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->products = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->products->toArray(),
            static fn(int $total, CartProduct $cartProduct): int => $total + $cartProduct->getValue(),
            0
        );
    }

    #[Pure]
    public function isFull(): bool
    {
        $totalQuantity = array_reduce(
            $this->products->toArray(),
            static fn(int $total, CartProduct $cartProduct): int => $total + $cartProduct->getQuantity(),
            0
        );

        return $totalQuantity >= self::CAPACITY;
    }

    public function getProducts(): iterable
    {
        return $this->products->getIterator();
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        if ($this->isFull()) {
            return;
        }

        $cartProduct = $this->findCartProduct($product);

        if ($cartProduct !== null) {
            $cartProduct->increaseQuantity($quantity);

            return;
        }

        $this->products->add(new CartProduct($product, $this, $quantity));
    }

    public function removeProduct(Product $product, int $quantity = 1): void
    {
        $cartProduct = $this->findCartProduct($product);

        if ($cartProduct === null) {
            return;
        }

        if ($cartProduct->getQuantity() - $quantity > 0) {
            $cartProduct->decreaseQuantity($quantity);
        } else {
            $this->products->removeElement($cartProduct);
        }
    }

    private function findCartProduct(Product $product): ?CartProduct
    {
        /** @var CartProduct|false $cartProduct */
        $cartProduct = $this->products
            ->filter(static fn(CartProduct $cartProduct): bool => $cartProduct->isSame($product))
            ->first();

        return $cartProduct ?: null;
    }
}
