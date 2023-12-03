<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page', 'products');

        $title = 'Products';
        $products = Product::with('category')->get()->toArray();
        // dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        $message = "Product Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }

    public function addEditProduct(Request $request, $id=null){
        //Get Categories and their sub categories
        $getCategories = Category::getCategories();
        $familyColors = Color::colors();

        //Get Product Filters
        $productsFilters = Product::productsFilters();

        if($id==''){
            $title = 'Add New Product';
            $product = new Product();
            $message = 'New Product Added Successfully!';
        }else{
            $product = Product::find($id);
            $title = 'Update product';
            $message = 'Product Updated Successfully!';
        }

        if($request->isMethod('post')){
            $data = $request->all();

            //Product Validation
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|max:255',
                'product_code' => 'required|regex:/^[\w-]*$/|max:255',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'family_color' => 'required|regex:/^[\pL\s\-]+$/u|max:255',

            ];

            $customMessages = [
                'category_id.required' => 'Category ID Required!',
                'product_name.required' => 'Product Name Required!',
                'product_name.max' => 'Product Name Maxed!',
                'product_code.required' => 'Product Code Required!',
                'product_code.regex' => 'Valid Product Code Required!',
                'product_price.required' => 'Product Price Required!',
                'product_price.numeric' => 'Valid Product Price Required!',
                'product_color.required' => 'Product Color Required!',
                'product_color.regex' => 'Valid Product Color Required!',
                'family_color.required' => 'Family Color Required!',
                'family_color.regex' => 'Valid Family Color Required!',
                'product_price.required' => 'Product Price Required!',
                'product_price.regex' => 'Valid Product Price Required!',

            ];

            $this->validate($request, $rules, $customMessages);

            //Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    //Upload Video
                    // $videoName = $video_tmp->getClientOriginalName();
                    $videoExtension = $video_tmp->getClientOriginalExtension();
                    $videoName = date('YmdHis').rand().'.'.$videoExtension;
                    $videoPath = "front/videos/products";
                    $video_tmp->move($videoPath,$videoName);

                    //Save Video Name in Product Table
                    $product->product_video = $videoName;
                }
            }

            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->family_color = $data['family_color'];
            $product->group_code = $data['group_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];

            if(!empty($data['product_discount']) && $data['product_discount'] > 0 ){
                $product->discount_type = 'product';
                $product->final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
            }else{
                $getCategoryDiscount = Category::select('category_discount')->where('id',$data['category_id'])->first();
                if($getCategoryDiscount->category_discount == 0 ){
                    $product->product_discount = "";
                    $product->final_price = $product->product_price;

                }else{
                    $product->discount_type = "category";
                    $product->final_price = $data['product_price'] - ($data['product_price'] * $getCategoryDiscount->category_discount)/100;
                }
            }

            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->search_keywords = $data['search_keywords'];
            $product->laptop = $data['laptop'];
            $product->computer = $data['computer'];
            $product->mobile = $data['mobile'];
            $product->company = $data['company'];
            $product->network = $data['network'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();

            return redirect('admin/products')->with('success_message',$message);


        }

        return view('admin.products.add_edit_product')->with(compact('getCategories','familyColors','title','message','productsFilters','product'));
    }

    public function deleteProductVideo($id){
        //Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        //Get Path
        $product_video_path = 'front/video/products';

        //Delete Product Video from folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        //Delete Product Video from Product Table
        Product::where('id',$id)->update(['product_video'=>'']);

        $message = 'Product Video Deleted Sccessfully!';
        return redirect()->back()->with('success_message',$message);
    }
}
