<?php

namespace Tests\Feature\Order;

use Tests\TestCase;
use Tests\CreateUser;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderIndexTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    public function testOrderIndex()
    {
        $this->createUser();

        $products = factory(ProductCategory::class, 10)->create()->each(function ($product) {
            $product->products()->save(factory(Product::class)->make());
        });

        $data = [
            'product_categories_id' => $products[5]->id
        ];

        $this->asUser()->json(
            'POST',
            '/api/cart',
            $data
        );

        $this->asUser()->post('/api/order');

        $response = $this->json('GET', '/api/order', []);

        $response->assertStatus(200);
    }
}
