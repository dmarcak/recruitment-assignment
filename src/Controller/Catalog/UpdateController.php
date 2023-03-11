<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\ChangeProductName;
use App\Messenger\ChangeProductPrice;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/{product}', name: 'product-update', methods: [Request::METHOD_PATCH])]
class UpdateController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(?Product $product, Request $request): Response
    {
        if ($product === null) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }

        if ($request->request->has('name')) {
            $this->dispatch(new ChangeProductName($product->getId(), trim($request->get('name'))));
        }

        if ($request->request->has('price')) {
            $this->dispatch(new ChangeProductPrice($product->getId(), $request->get('price')));
        }

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
