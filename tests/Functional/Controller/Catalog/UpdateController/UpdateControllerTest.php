<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Tests\Functional\WebTestCase;

final class UpdateControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new UpdateControllerFixture());
    }

    public function test_update_product_name(): void
    {
        $this->client->request('PATCH', '/products/' . UpdateControllerFixture::PRODUCT_ID, [
            'name' => 'Product name',
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertSame('Product name', $response['products'][0]['name']);
    }
    public function test_update_product_price(): void
    {
        $this->client->request('PATCH', '/products/' . UpdateControllerFixture::PRODUCT_ID, [
            'price' => 2990,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertSame(2990, $response['products'][0]['price']);
    }
    public function test_update_product_name_and_price(): void
    {
        $this->client->request('PATCH', '/products/' . UpdateControllerFixture::PRODUCT_ID, [
            'name' => 'Product name',
            'price' => 2990,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertSame('Product name', $response['products'][0]['name']);
        self::assertSame(2990, $response['products'][0]['price']);
    }
}
