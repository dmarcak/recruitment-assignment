<?php

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

class CartBuilder
{
    /**
     * @return array{total_price: int, products: array<int, array{id: string, name: string, price: int}>}
     */
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products' => []
        ];

        foreach ($cart->getProducts() as $cartProduct) {
            $product = $cartProduct->getProduct();

            $data['products'][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $cartProduct->getQuantity() * $product->getPrice()
            ];
        }

        return $data;
    }
}
