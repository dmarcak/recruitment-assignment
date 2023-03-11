<?php

namespace App\Messenger;

class AddProductToCatalog implements AsyncCommand
{
    public function __construct(public readonly string $name, public readonly int $price) {}
}
