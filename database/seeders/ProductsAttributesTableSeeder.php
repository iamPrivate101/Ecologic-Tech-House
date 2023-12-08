<?php

namespace Database\Seeders;

use App\Models\ProductsAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ProductsAttributesRecord = [
            ['id'=>1, 'product_id'=>12,'size'=>'Small', 'sku'=>'led-s', 'price'=>1000, 'stock'=>100, 'status'=>1],
            ['id'=>2, 'product_id'=>12,'size'=>'Medium', 'sku'=>'led-m', 'price'=>1200, 'stock'=>80, 'status'=>1],
            ['id'=>3, 'product_id'=>12,'size'=>'Large', 'sku'=>'led-l', 'price'=>1400, 'stock'=>50, 'status'=>1],
        ];

        ProductsAttribute::insert($ProductsAttributesRecord);

    }
}
