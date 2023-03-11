<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity]
class CartProduct
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, fetch: 'EAGER')]
    private Product $product;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'id')]
    private Cart $cart;

    #[ORM\Column]
    private int $quantity;

    public function __construct(Product $product, Cart $cart, int $quantity)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->quantity = $quantity;
    }

    #[Pure]
    public function getProduct(): Product
    {
        return $this->product;
    }

    #[Pure]
    public function getValue(): int
    {
        return $this->product->getPrice() * $this->quantity;
    }

    #[Pure]
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    #[Pure]
    public function isSame(Product $product): bool
    {
        return $this->product->equals($product);
    }

    public function increaseQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        $this->quantity -= $quantity;
    }
}