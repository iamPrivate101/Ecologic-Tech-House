<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

        //Get Related Products
        $relatedProducts = Product::with('brand','images')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(8)->inRandomOrder()->get()->toArray();
        // dd($relatedProducts);

        //Set Session For Recently Viewed Item
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(),true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        //Insert product in recently_viewed_items table if not already exists
        $countRecentlyViwedItems = DB::table('recently_viewed_items')->where(['product_id'=>$id, 'session_id'=>$session_id])->count();
        if($countRecentlyViwedItems == 0){
            DB::table('recently_viewed_items')->insert(['product_id'=>$id, 'session_id'=>$session_id]);
        }

        //Get Recently Viewed Products Ids
        $recentProductIds = DB::table('recently_viewed_items')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->take(8)->pluck('product_id');
        // dd($recentProductIds);

        //Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand','images')->whereIn('id',$recentProductIds)->get()->toArray();
        // dd($recentlyViewedProducts);


        return view('front.products.detail')->with(compact('productDetails','categoryDetails','groupProducts','relatedProducts','recentlyViewedProducts'));
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

    public function addToCart(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // print_r($data);die;

            //Check Product Stock
            $productStock = ProductsAttribute::productStock($data['product_id'], $data['size']);
            if($data['qty'] > $productStock){
                $message = "Required Quantity Is Not Available!!!";
                return response()->json(['status'=>false, 'message'=>$message]);
            }

            //Check Product Status
            $productStatus = Product::productStatus($data['product_id']);
            if($productStatus == 0){
                $message = "Product Is Not Available!!!";
                return response()->json(['status'=>false, 'message'=>$message]);
            }

            //Generate Session Id if not exists
            if(empty(Session::get('session_id'))){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }else{
                $session_id = Session::get('session_id');
            }
            // echo $session_id;

            //Check Product if Already exists in Cart
            if(Auth::check()){
                //User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'product_size'=>$data['size'],'user_id'=>$user_id])->count();


            }else{
                //User is not loggeg in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'product_size'=>$data['size'],'session_id'=>$session_id])->count();
            }

            if($countProducts > 0){
                $message = "Products Already Exists In Cart";
                return response()->json(['status'=>false, 'message'=>$message]);
            }

            //Save The Product In The Cart
            $item = new Cart;
            $item->session_id = $session_id;
            if(Auth::check()){
                $item->user_id = Auth::user()->id;
            }else{
                $item->user_id = 0;
            }
            $item->product_id = $data['product_id'];
            $item->product_size = $data['size'];
            $item->product_qty = $data['qty'];
            $item->save();
            $message = "Product Added Successfully In Cart";
            return response()->json(['status'=>true, 'message'=>$message]);


        }
    }
}
