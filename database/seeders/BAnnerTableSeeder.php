<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BAnnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecord = [
            ['id'=>1, 'type'=>'Slider', 'image'=>'1.jpeg', 'link'=>'', 'title'=>'New Laptop', 'alt'=>'laptop', 'sort'=>1, 'status'=>1],
            ['id'=>2, 'type'=>'Slider', 'image'=>'2a.jpeg', 'link'=>'', 'title'=>'New Laptop', 'alt'=>'laptop', 'sort'=>1, 'status'=>1],
            ['id'=>3, 'type'=>'Slider', 'image'=>'2a.jpeg', 'link'=>'', 'title'=>'New Laptop', 'alt'=>'laptop', 'sort'=>1, 'status'=>1],

        ];
        Banner::insert($bannerRecord);
        //
    }
}
