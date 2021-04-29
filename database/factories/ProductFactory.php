<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $categoryIds = ProductCategory::all()->pluck('id');
        return [
            'product_name'        => [
                'en' => $this->faker->name()
            ],
            'product_desc'        => [
                'en' => $this->faker->realText()
            ],
            'product_category_id' => $categoryIds->random(),
            'product_price'       => $this->faker->randomFloat(2, 0, 2500),
        ];
    }
}
