<?php

namespace App\Tests\Functional\Controller\Cart\RemoveProductController;

use App\Entity\Cart;
use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RemoveProductControllerFixture extends AbstractFixture
{

    public function load(ObjectManager $manager): void
    {
        $product = new Product('d11e1e69-cca7-40a1-8273-9d93c8346efd', 'Product 1', 1990, new DateTimeImmutable('2023-03-07 14:25:01'));
        $manager->persist($product);

        $product2 = new Product('7bcf6fe9-e831-4776-a9df-76a702233adc', 'Product 2', 2990, new DateTimeImmutable('2023-03-07 14:25:02'));
        $manager->persist($product2);

        $cart = new Cart('97e385fe-9876-45fc-baa0-4f2f0df90950');
        $cart->addProduct($product);
        $manager->persist($cart);

        $cartWithMultipleProducts = new Cart('de5a8de9-39f7-4c8d-9ac5-f26f4ef989bc');
        $cartWithMultipleProducts->addProduct($product, 2);
        $cartWithMultipleProducts->addProduct($product2);
        $manager->persist($cartWithMultipleProducts);

        $manager->flush();
    }
}
