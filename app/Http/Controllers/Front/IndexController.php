<?php

namespace App\Http\Controllers\Front;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{public function index(){
    //Get Home Page Slider Banner
    $homeSliderBanners = Banner::where('type','Slider')->where('status',1)->orderBy('sort','ASC')->get()->toArray();

    //Get Home Page Fix Banner
    $homeFixBanners = Banner::where('type','Fix')->where('status',1)->orderBy('sort','ASC')->get()->toArray();

    //Get new Arrival Product
    $newProducts = Product::with(['brand','images'])->where('status',1)->orderBy('id','DESC')->limit(8)->get()->toArray();
    // dd($newProducts);

    //best Seller
    $bestSellers = Product::with(['brand','images'])->where(['is_bestseller' => 'Yes','status'=>1])->inRandomOrder()->limit(4)->get()->toArray();

    //Discounted Product
    $discountedProducts = Product::with(['brand','images'])->where('product_discount', '>', 0)->where('status',1)->inRandomOrder()->limit(4)->get()->toArray();

    //Featured Seller
    $featuredProducts = Product::with(['brand','images'])->where(['is_featured' => 'Yes','status'=>1])->inRandomOrder()->limit(8)->get()->toArray();

    return view('front.index')->with(compact('homeSliderBanners', 'homeFixBanners', 'newProducts','bestSellers','discountedProducts','featuredProducts'));
}

}
