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

    public static function getSizes($catIds){
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        $getProductSizes = ProductsAttribute::select('size')->where('status',1)
            ->whereIn('product_id',$getProductIds)->groupBy('size')->pluck('size');
        // dd($getProductSizes);
        return $getProductSizes;
    }

    public static function getBrands($catIds){
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        $getProductBrandIds = Product::select('brand_id')->whereIn('id',$getProductIds)->groupBy('brand_id')->pluck('brand_id');
        $getProductBrands = Brand::select('id','brand_name')->where('status',1)->whereIn('id',$getProductBrandIds)->orderBy('brand_name','ASC')->get()->toArray();
        // dd($getProductBrands);

        return $getProductBrands;
    }
}
