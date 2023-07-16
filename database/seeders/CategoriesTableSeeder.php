<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $category = new Category();
       $category->id = 1;
       $category->category = 'Animals';
       $category->save();

       $category = new Category();
       $category->id = 2;
       $category->category = 'Security';
       $category->save();
    }
}
