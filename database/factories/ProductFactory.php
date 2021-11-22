<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);
        $category = Category::inRandomOrder()
        ->limit(1)
        ->first(['id']);

        $status = ['active', 'draft'];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => $category ? $category->id : null,
            'description' => $this->faker->words(200, true),
            'image_path' => $this->faker->imageUrl(),
            'status' => $status[rand(0, 1)],
            'price' => $this->faker->randomFloat(2, 50, 2000),
            'quantity' => $this->faker->randomFloat(0, 0, 20),
        ];
    }
}
