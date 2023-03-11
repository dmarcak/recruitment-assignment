<?php

namespace App\Repository;

use App\Service\Catalog\Product;
use App\Service\Catalog\ProductProvider;
use App\Service\Catalog\ProductService;
use App\Service\Clock;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;

class ProductRepository implements ProductProvider, ProductService
{
    /** @var EntityRepository<\App\Entity\Product> */
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly Clock $clock)
    {
        $this->repository = $this->entityManager->getRepository(\App\Entity\Product::class);
    }

    public function getProducts(int $page = 0, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->setMaxResults($count)
            ->setFirstResult($page * $count)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function exists(string $productId): bool
    {
        return $this->repository->find($productId) !== null;
    }

    public function add(string $name, int $price): Product
    {
        $product = new \App\Entity\Product(Uuid::uuid4(), $name, $price, $this->clock->now());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function remove(string $id): void
    {
        $product = $this->repository->find($id);

        if ($product !== null) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }

    public function changeName(string $id, string $name): void
    {
        /** @var \App\Entity\Product|null $product */
        $product = $this->repository->find($id);

        if ($product !== null) {
            $product->setName($name);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }

    public function changePrice(string $id, int $price): void
    {
        /** @var \App\Entity\Product|null $product */
        $product = $this->repository->find($id);

        if ($product !== null) {
            $product->setPrice($price);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }
}
