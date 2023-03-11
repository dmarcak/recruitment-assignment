<?php

namespace App\Messenger;

class RemoveProductFromCart implements AsyncCommand
{
    public function __construct(public readonly string $cartId, public readonly string $productId) {}
}
