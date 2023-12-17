<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getColors($catIds){
        //all the products that fall under the category id array
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        // dd($getProductIds);

        //get product colors for the available products
        $getProductColors = Product::select('family_color')->whereIn('id',$getProductIds)->groupBy('family_color')->pluck('family_color');
        // dd($getProductColors);

        return $getProductColors;
    }
}
