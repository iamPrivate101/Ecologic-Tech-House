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
    $newProducts = Product::with(['brand','images'])->where('status',1)->orderBy('id','DESC')->limit(4)->get()->toArray();
    // dd($newProducts);

    return view('front.index')->with(compact('homeSliderBanners', 'homeFixBanners', 'newProducts'));
}

}
