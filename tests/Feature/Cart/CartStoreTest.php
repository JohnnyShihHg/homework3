<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Tests\CreateUser;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartStoreTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    public function testCartStore()
    {
        $this->createUser();

        $products = factory(ProductCategory::class, 10)->create()->each(function ($product) {
            $product->products()->save(factory(Product::class)->make());
        });

        $data = [
            'product_categories_id' => $products[5]->id
        ];

        $response = $this->asUser()->json(
            'POST',
            '/api/cart',
            $data
        );

        $response->assertStatus(200);
    }
}
