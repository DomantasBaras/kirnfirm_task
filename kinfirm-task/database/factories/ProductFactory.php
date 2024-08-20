<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->numerify('SKU###'),
            'description' => $this->faker->sentence(),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'photo' => $this->faker->imageUrl(200, 200), // Small image URL
        ];
    }
}
