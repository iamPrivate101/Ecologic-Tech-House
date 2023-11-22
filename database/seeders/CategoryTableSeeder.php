<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords = [
            ['id' => 1, 'parent_id' => 0, 'category_name' => 'Clothing', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'clothing', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 2, 'parent_id' => 0, 'category_name' => 'Electronics', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'electronics', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 3, 'parent_id' => 0, 'category_name' => 'Appliances', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'appliances', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 4, 'parent_id' => 1, 'category_name' => 'Men', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'Men', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 5, 'parent_id' => 1, 'category_name' => 'Women', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'women', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 6, 'parent_id' => 1, 'category_name' => 'Kids', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'kids', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 7, 'parent_id' => 2, 'category_name' => 'Computer', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'computer', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 8, 'parent_id' => 2, 'category_name' => 'Laptop', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'laptop', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 9, 'parent_id' => 2, 'category_name' => 'Mobile', 'category_image' => '', 'category_discount' => '0.0',
                'description' => '', 'url' => 'mobile', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
        ];

        Category::insert($categoryRecords);
    }
}
