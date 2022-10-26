<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductCategoryIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testProductCategoryIndex()
    {
        factory(ProductCategory::class, 10)->create()->each(function ($product) {
            $product->products()->save(factory(Product::class)->make());
        });

        $response = $this->json('GET', '/api/productCategory', []);

        $response->assertStatus(200);
    }
}
