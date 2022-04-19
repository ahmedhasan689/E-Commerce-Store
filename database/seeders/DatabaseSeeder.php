<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // To Run Factory
        // Category::factory(10)->create();
        Product::factory(50)->create();

        // To Run Seeder
        $this->call([
            // CategoriesTableSeeder::class,
            // UsersTableSeeder::class,
        ]);
    }
}
