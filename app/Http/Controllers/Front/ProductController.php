<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function listing(){
         $url = Route::getFacadeRoot()->current()->uri;  //helps to fetch the url entered in brouser
        //  echo $url; die;
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if($categoryCount>0){
            // echo "category exists";
            //Get Category Detail
            $categoryDetails = Category::categoryDetails($url);
            // dd($categoryDetails);

            //Get Category Adn Their Sub Category Product
            $categoryProducts = Product::with(['brand','images'])->whereIn('category_id',$categoryDetails['catIds'])->where('status',1)
                ->orderBy('id','DESC')->get()->toArray();
            // dd($categoryProducts);

            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts') );

        }else{
            abort(404);
        }
    }
}
