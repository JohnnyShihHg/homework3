<?php

use Illuminate\Database\Seeder;

class Product_CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProductCategory::class, 10)->create()->each(function ($product) {
            $product->products()->save(factory(App\Models\Product::class)->make());
        });
    }
}
