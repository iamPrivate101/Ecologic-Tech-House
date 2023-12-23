<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public static function productsFilters(){
        $productsFilters['laptopArray']=array('Dell','Hp','Lenove','Acer'); //fabric
        $productsFilters['computerArray']=array('Dell','Compace','Samsung','IBM');  //sleeve
        $productsFilters['mobileArray']=array('Samsung','Oppo','Mi','Iphone','Nokia','Motorola'); //pattern
        $productsFilters['companyArray']=array('Apple','Microsoft','Samsung','Dell','Nokia','Hp'); //fit
        $productsFilters['networkArray']=array('NTC','Ncell','Worldlink','Subisu','Vianet');  //occasion
        return $productsFilters;
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public static function getAttributePrice($product_id, $size){
        $attributePrice = ProductsAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        //For Getting Product Discount
        $productDetails = Product::select('product_discount','category_id','brand_id')->where('id',$product_id)->first()->toArray();

        //For Getting Category Discount
        $categoryDetails = Category::select('category_discount')->where('id',$productDetails['category_id'])->first()->toArray();

        //For Getting Brand Discount
        $brandDetails = Brand::select('brand_discount')->where('id',$productDetails['brand_id'])->first()->toArray();

        if($productDetails['product_discount'] > 0){
            //1st CASE : If there is any product discount
            $discount = $attributePrice['price'] * $productDetails['product_discount'] / 100;
            $discount_percent = $productDetails['product_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }elseif($categoryDetails['category_discount'] > 0){
            //2nd CASE : If there is any category discount
            $discount = $attributePrice['price'] * $categoryDetails['category_discount'] / 100;
            $discount_percent = $categoryDetails['category_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }elseif($brandDetails['brand_discount'] > 0){
            //3rd CASE : If there is any brand discount
            $discount = $attributePrice['price'] * $brandDetails['brand_discount'] / 100;
            $discount_percent = $brandDetails['brand_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }else{
            // 4th CASE : No Discount
            $discount = 0;
            $discount_percent = 0;
            $final_price = $attributePrice['price'];
        }

        return array('product_price'=>$attributePrice['price'], 'final_price'=>$final_price, 'discount'=>$discount, 'discount_percent'=>$discount_percent);

    }

    public static function productStatus($product_id){
        $productStatus = Product::select('status')->where('id',$product_id)->first();
        return $productStatus->status;
    }
}
