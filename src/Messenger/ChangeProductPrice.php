<?php

namespace App\Messenger;

final class ChangeProductPrice
{
    public function __construct(public readonly string $id, public readonly int $price)
    {

    }
}