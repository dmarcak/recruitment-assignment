<?php

namespace App\Service\Catalog;

interface ProductService
{
    public function add(string $name, int $price): Product;

    public function remove(string $id): void;

    public function changeName(string $id, string $name): void;

    public function changePrice(string $id, int $price): void;
}
