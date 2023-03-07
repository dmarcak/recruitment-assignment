<?php

namespace App\Messenger;

final class ChangeProductName
{
    public function __construct(public readonly string $id, public readonly string $name)
    {
    }
}