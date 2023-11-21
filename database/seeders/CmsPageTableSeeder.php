<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPagesRecords = [
            ['id'=>1,'title'=>'About Us','description'=>'Content is comming soon','url'=>'about-us',
                'meta_title'=>'About Us','meta_description'=>'About Us Content','meta_keywords'=>'about, about us', 'status'=>1],

            ['id'=>2,'title'=>'Terms & Condition','description'=>'Content is comming soon','url'=>'terms-conditon',
                'meta_title'=>'Terms & Condition','meta_description'=>'Terms & Condition Content','meta_keywords'=>'terms, terms conditions', 'status'=>1],

            ['id'=>3,'title'=>'Policy and Privacy','description'=>'Content is comming soon','url'=>'policy-privacy',
                'meta_title'=>'Policy Privacy','meta_description'=>'Policy Privacy','meta_keywords'=>'policy privacy','status'=>1],
        ];
        CmsPage::insert($cmsPagesRecords);
    }
}
