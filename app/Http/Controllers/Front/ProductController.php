<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductsFilter;
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

            //Update Query for Price Filter
            if(isset($request['price']) && !empty($request['price'])){
                $request['price'] = str_replace("~","-",$request['price']);
                $prices = explode('-', $request['price']);
                // print_r($prices);die;
                $count = count($prices);
                $categoryProducts->whereBetween('products.final_price',[$prices[0],$prices[$count-1]]);
            }

            //Update Query For Dynamic Filters
            $filterTypes = ProductsFilter::filterTypes();
            foreach ($filterTypes as $key => $filter){
                if($request->$filter){
                    $explodeFilterVals = explode('~',$request->$filter);
                    $categoryProducts->whereIn($filter,$explodeFilterVals);

                }
            }


            $categoryProducts = $categoryProducts->paginate(6);

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

    public function detail($id){
        $productCount = Product::where('status',1)->where('id',$id)->count();
        if($productCount == 0){
            abort(404);
        }
        $productDetails = Product::with(['category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images'])->find($id)->toArray();
        // dd($productDetails);
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);

        //Get Group Products (Product Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_color')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'], 'status'=>1])->get()->toArray();


        }
        // dd($groupProducts);

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','groupProducts'));
    }

    public function getAttributePrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            $getAttributePrice = Product::getAttributePrice($data['product_id'],$data['size']);
            // echo"<pre>";print_r($getAttributePrice);die;

            return $getAttributePrice;
        }

    }
}
