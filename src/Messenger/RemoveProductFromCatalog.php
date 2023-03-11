<?php

namespace App\Messenger;

class RemoveProductFromCatalog implements AsyncCommand
{
    public function __construct(public readonly string $productId) {}
}
