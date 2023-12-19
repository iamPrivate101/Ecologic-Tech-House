<?php

namespace Database\Seeders;

use App\Models\ProductsFilter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filterRecords = [
            ['id'=>1, 'filter_name'=>'Laptop', 'filter_value'=>'Dell', 'sort'=>1, 'status'=>1 ],
            ['id'=>2, 'filter_name'=>'Laptop', 'filter_value'=>'Acer', 'sort'=>2, 'status'=>1 ],
            ['id'=>3, 'filter_name'=>'Laptop', 'filter_value'=>'Lenove', 'sort'=>3, 'status'=>1 ],
            ['id'=>4, 'filter_name'=>'Laptop', 'filter_value'=>'Asus', 'sort'=>4, 'status'=>1 ],
            ['id'=>5, 'filter_name'=>'Laptop', 'filter_value'=>'Hp', 'sort'=>5, 'status'=>1 ],
            ['id'=>6, 'filter_name'=>'Laptop', 'filter_value'=>'Apple', 'sort'=>6, 'status'=>1 ],
            ['id'=>7, 'filter_name'=>'Laptop', 'filter_value'=>'Microsoft', 'sort'=>7, 'status'=>1 ],
            ['id'=>8, 'filter_name'=>'Laptop', 'filter_value'=>'Msi', 'sort'=>8, 'status'=>1 ],
            ['id'=>9, 'filter_name'=>'Laptop', 'filter_value'=>'Samsung', 'sort'=>9, 'status'=>1 ],


            ['id'=>10, 'filter_name'=>'Computer', 'filter_value'=>'Dell', 'sort'=>1, 'status'=>1 ],
            ['id'=>11, 'filter_name'=>'Computer', 'filter_value'=>'Acer', 'sort'=>2, 'status'=>1 ],
            ['id'=>12, 'filter_name'=>'Computer', 'filter_value'=>'Lenove', 'sort'=>3, 'status'=>1 ],
            ['id'=>13, 'filter_name'=>'Computer', 'filter_value'=>'Samsung', 'sort'=>9, 'status'=>1 ],
            ['id'=>14, 'filter_name'=>'Computer', 'filter_value'=>'Asus', 'sort'=>4, 'status'=>1 ],
            ['id'=>15, 'filter_name'=>'Computer', 'filter_value'=>'Hp', 'sort'=>5, 'status'=>1 ],
            ['id'=>16, 'filter_name'=>'Computer', 'filter_value'=>'Apple', 'sort'=>6, 'status'=>1 ],
            ['id'=>17, 'filter_name'=>'Computer', 'filter_value'=>'Microsoft', 'sort'=>7, 'status'=>1 ],
            ['id'=>18, 'filter_name'=>'Computer', 'filter_value'=>'Msi', 'sort'=>8, 'status'=>1 ],

            ['id'=>19, 'filter_name'=>'Mobile', 'filter_value'=>'Xiaomi', 'sort'=>1, 'status'=>1 ],
            ['id'=>20, 'filter_name'=>'Mobile', 'filter_value'=>'Vivo', 'sort'=>2, 'status'=>1 ],
            ['id'=>21, 'filter_name'=>'Mobile', 'filter_value'=>'Realme', 'sort'=>3, 'status'=>1 ],
            ['id'=>22, 'filter_name'=>'Mobile', 'filter_value'=>'Samsung', 'sort'=>1, 'status'=>1 ],
            ['id'=>23, 'filter_name'=>'Mobile', 'filter_value'=>'Oppo', 'sort'=>4, 'status'=>1 ],
            ['id'=>24, 'filter_name'=>'Mobile', 'filter_value'=>'OnePlus', 'sort'=>5, 'status'=>1 ],
            ['id'=>25, 'filter_name'=>'Mobile', 'filter_value'=>'Apple', 'sort'=>6, 'status'=>1 ],
            ['id'=>26, 'filter_name'=>'Mobile', 'filter_value'=>'Nokia', 'sort'=>7, 'status'=>1 ],

            ['id'=>27, 'filter_name'=>'Network', 'filter_value'=>'WorldLink', 'sort'=>1, 'status'=>1 ],
            ['id'=>28, 'filter_name'=>'Network', 'filter_value'=>'Vianet', 'sort'=>2, 'status'=>1 ],
            ['id'=>29, 'filter_name'=>'Network', 'filter_value'=>'Subisu', 'sort'=>3, 'status'=>1 ],
            ['id'=>30, 'filter_name'=>'Network', 'filter_value'=>'ClassicTech', 'sort'=>1, 'status'=>1 ],
            ['id'=>31, 'filter_name'=>'Network', 'filter_value'=>'NepalTelecom', 'sort'=>4, 'status'=>1 ],
            ['id'=>32, 'filter_name'=>'Network', 'filter_value'=>'DishHome', 'sort'=>5, 'status'=>1 ],
            ['id'=>33, 'filter_name'=>'Network', 'filter_value'=>'Ncell', 'sort'=>6, 'status'=>1 ],
            ['id'=>34, 'filter_name'=>'Network', 'filter_value'=>'CG', 'sort'=>7, 'status'=>1 ],


        ];

        ProductsFilter::insert($filterRecords);

    }
}
