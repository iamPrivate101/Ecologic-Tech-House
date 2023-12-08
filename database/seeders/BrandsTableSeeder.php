<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandsRecord = [
            ['id' => 1, 'brand_name' => 'Microsoft', 'brand_image' => '', 'brand_logo' => '', 'brand_discount' => 0,
             'description' => '', 'url' => 'microsoft', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
             ['id' => 2, 'brand_name' => 'Apple', 'brand_image' => '', 'brand_logo' => '', 'brand_discount' => 0,
             'description' => '', 'url' => 'apple', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
             ['id' => 3, 'brand_name' => 'Samsung', 'brand_image' => '', 'brand_logo' => '', 'brand_discount' => 0,
             'description' => '', 'url' => 'samsung', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
             ['id' => 4, 'brand_name' => 'LG', 'brand_image' => '', 'brand_logo' => '', 'brand_discount' => 0,
             'description' => '', 'url' => 'lg', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
             ['id' => 5, 'brand_name' => 'Mi', 'brand_image' => '', 'brand_logo' => '', 'brand_discount' => 0,
             'description' => '', 'url' => 'mi', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],

        ];

        Brand::insert($brandsRecord);
    }
}
