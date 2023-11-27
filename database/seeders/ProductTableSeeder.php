<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsRecord = [
            ['id'=>1,'category_id'=>'1','brand_id'=>0,'product_name'=>'Blue Tshirt','product_code'=>'BT001','product_color'=>'Dark Blue','family_color'=>'Blue',
            'group_code'=>'TSHIRT001','product_price'=>1500,'product_discount'=>'10','discount_type'=>'product','final_price'=>1350,'product_weight'=>500,
            'product_video'=>'','description'=>'test production','wash_care'=>'','keywords'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'',
            'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],

            ['id'=>2,'category_id'=>'1','brand_id'=>0,'product_name'=>'White Tshirt','product_code'=>'BT001','product_color'=>'Dark White','family_color'=>'Blue',
            'group_code'=>'TSHIRT001','product_price'=>1500,'product_discount'=>'10','discount_type'=>'product','final_price'=>1350,'product_weight'=>500,
            'product_video'=>'','description'=>'test production','wash_care'=>'','keywords'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'',
            'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],
        ];
        Product::insert($productsRecord);
    }


}
