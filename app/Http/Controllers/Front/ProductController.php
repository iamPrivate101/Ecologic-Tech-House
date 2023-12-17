<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function listing(Request $request){
         $url = Route::getFacadeRoot()->current()->uri;  //helps to fetch the url entered in brouser
        //  echo $url; die;
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if($categoryCount>0){
            // echo "category exists";
            //Get Category Detail
            $categoryDetails = Category::categoryDetails($url);
            // dd($categoryDetails);

            //Get Category Adn Their Sub Category Product
            $categoryProducts = Product::with(['brand','images'])->whereIn('category_id',$categoryDetails['catIds'])->where('products.status',1);

            // dd($categoryProducts);

            //Update Query For Product Sorting
            if(isset($request['sort']) && !empty($request['sort'])){
                if($request['sort'] == "product_latest"){
                    $categoryProducts->orderBy('id','DESC');
                }else if($request['sort'] == "lowest_price"){
                    $categoryProducts->orderBy('final_price','ASC');
                }else if($request['sort'] == "highest_price"){
                    $categoryProducts->orderBy('final_price','DESC');
                }else if($request['sort'] == "best_selling"){
                    $categoryProducts->where('is_bestseller','Yes');
                }else if($request['sort'] == "featured_items"){
                    $categoryProducts->where('is_featured','Yes');
                }else if($request['sort'] == "discounted_items"){
                    $categoryProducts->where('product_discount','>',0);
                }else{
                    $categoryProducts->orderBy('products.id','DESC');
                }

            }

            //Update Query For Color Filter
            if(isset($request['color']) && !empty($request['color'])){
                //from the url like --- http://127.0.0.1:8000/laptops?color=Black~Silver&sort=Sort%20By:%20Newest%20Items
                $colors = explode('~', $request['color']);  //color=Black~Silver
                $categoryProducts->whereIn('products.family_color',$colors);
            }

            //Update Query for Sizes Filter from ProductAttribute table
            if(isset($request['size']) && !empty($request['size'])){
                $sizes = explode('~', $request['size']);
                $categoryProducts->join('products_attributes','products_attributes.product_id','=','products.id')
                    ->whereIn('products_attributes.size',$sizes);
                    // ->groupBy('products_attributes.product_id'); //issue in size filter

            }

            //Update Query for Brand Filter
            if(isset($request['brand']) && !empty($request['brand'])){
                $brands = explode('~', $request['brand']);
                $categoryProducts->whereIn('products.brand_id',$brands);
            }


            $categoryProducts = $categoryProducts->paginate(1);

            if($request->ajax()){
                return response()->json([
                    'view' => (String)View::make('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts','url'))
                ]);
            }else{
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts','url') );
            }

        }else{
            abort(404);
        }
    }
}
