<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Category::class;

    public function definition()
    {
        // Faker
        $name = $this->faker->words(2, true);
        $category = DB::table('categories')->inRandomOrder()->limit(1)->first(['id']);
        $status = ['active', 'draft'];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => $category ? $category->id : null,
            'description' => $this->faker->words(200, true),
            'image_path' => $this->faker->imageUrl(),
            'status' => $status[rand(0, 1)],
        ];
    }
}
