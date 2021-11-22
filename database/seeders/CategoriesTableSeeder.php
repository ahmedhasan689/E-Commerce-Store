<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Type Of Database :-
           1- ORM => Eloquent Model :
        */
        Category::create([
            'name'   => 'From Model',
            'slug'   => 'from-model',
            'status' => 'draft',
        ]);

        /*
           2- Query Builder :
                */

//        DB::table('categories')->insert([
//            'name'   => 'My First Category',
//            'slug'   => 'my-first-category',
//            'status' => 'active',
//        ]);
//
//        DB::table('categories')->insert([
//            'name'      => 'Category',
//            'slug'      => 'sub-category',
//            'parent_id' => 1,
//            'status'    => 'active',
//        ]);

        /*
           3- Raw Query => SQL Commands :

        */

    }
}
