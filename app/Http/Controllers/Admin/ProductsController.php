<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Models\ProductsImage;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page', 'products');

        $title = 'Products';
        $products = Product::with('category')->get()->toArray();

         //Set Admin/SubAdmins Permissions for Products
         $productsModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'products'])->count();
         $productsModule = array();
         if (Auth::guard('admin')->user()->type == 'admin') {
             $productsModule['view_access'] = 1;
             $productsModule['edit_access'] = 1;
             $productsModule['full_access'] = 1;
         } else if ($productsModuleCount == 0) {
             $message = "This Feature is Restricted For You";
             return redirect('admin/dashboard')->with('error_message', $message);
         } else {
             $productsModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'products'])->first()->toArray();
         }
        return view('admin.products.products')->with(compact('products','productsModule'));
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

        //Set Admin/SubAdmins Permissions for Products
        $categoriesModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->count();
        $categoriesModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;
        } else if ($categoriesModuleCount == 0) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $categoriesModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->first()->toArray();
        }

        if ($categoriesModule['edit_access'] != 1 || $categoriesModule['full_access'] != 1) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        }

        //Get Categories and their sub categories
        $getCategories = Category::getCategories();
        $familyColors = Color::colors();

        //Get Brands
        $getBrands = Brand::where('status',1)->get()->toArray();

        //Get Product Filters
        $productsFilters = Product::productsFilters();

        if($id==''){
            $title = 'Add New Product';
            $product = new Product();
            $message = 'New Product Added Successfully!';
        }else{
            $product = Product::with(['attributes','images'])->find($id);
            $title = 'Update product';
            // dd($product['attributes']);
            $message = 'Product Updated Successfully!';
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
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

            if(!isset($data['product_discount']) || empty($data['product_discount'])){
                $data['product_discount'] = '0';
            }

            if(!isset($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
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
                    $product->product_discount = "0";
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

            if(!empty($data['is_bestseller'])){
                $product->is_bestseller = $data['is_bestseller'];
            }else{
                $product->is_bestseller = "No";
            }
            $product->status = 1;
            $product->save();

            //for product images
            if($id == ''){
                 $product_id = DB::getPdo()->lastInsertId(); //get the id of last insert product for the image
            }else{
                 $product_id = $id;
            }

            if($request->hasFile('product_images')){
                $images = $request->file('product_images');

                foreach ($images as $key => $image) {
                    //Generate Temp Image
                    $image_temp = Image::make($image);

                    //Get Image Extension
                    $extension = $image->getClientOriginalExtension();

                    //Generate New Image Name
                    $imageName = 'product-'.date('YmdHis').rand(111,999).'.'.$extension;

                    //Image Path For Small, Medium, Large
                    $largeImagePath = 'front/images/products/large/'.$imageName;
                    $mediumImagePath = 'front/images/products/medium/'.$imageName;
                    $smallImagePath = 'front/images/products/small/'.$imageName;

                    //Upload the Large,Medium,Small Images after Resize
                    Image::make($image_temp)->resize(1040,1200)->save($largeImagePath);
                    Image::make($image_temp)->resize(520,600)->save($mediumImagePath);
                    Image::make($image_temp)->resize(260,300)->save($smallImagePath);

                    //Insert Image name in product_images table
                    $image = new ProductsImage();
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->image_sort = 1;
                    $image->save();


                }
            }

            //Sort Product Image
            if($id != ""){
                if(isset($data['image'])){
                    foreach ($data['image'] as $key => $image) {
                        ProductsImage::where(['product_id'=>$id, 'image'=>$image])->update(['image_sort'=>$data['image_sort'][$key]]);
                    }
                }
            }

            //Add Product Attribute
            foreach ($data['sku'] as $key => $value) {
                if(!empty($value)){
                    //SKU already Exists
                    $countSKU = ProductsAttribute::where('sku',$value)->count();
                    if($countSKU > 0){
                        $message = 'SKU Already Exists! Please Add Another SKU';
                        return redirect()->back()->with('error_message',$message);
                    }

                    //Size Already Exist Check
                    $countSize = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$data['size'][$key]])->count();
                    if($countSize > 0){
                        $message = 'Size Already Exists! Please Add Another Size';
                        return redirect()->back()->with('error_message',$message);
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $product_id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status =1;
                    $attribute->save();

                }
            }

            //Edit Product Attribute
            if(isset($data['attributeId'])){
                foreach ($data['attributeId'] as $akey => $attribute) {
                    if(!empty($attribute)){
                        ProductsAttribute::where(['id'=>$data['attributeId'[$akey]]])->update(['price'=>$data['price'][$akey], 'stock'=>$data['stock'][$akey]]);
                    }
                }
            }



            return redirect('admin/products')->with('success_message',$message);


        }

        return view('admin.products.add_edit_product')->with(compact('getCategories','familyColors','title','message','productsFilters','product','getBrands'));
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

    public function deleteProductImage($id){
        //Get Product Image
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        //Image Path For Small, Medium, Large
        $large_image_path = 'front/images/products/large/';
        $medium_image_path = 'front/images/products/medium/';
        $small_image_path = 'front/images/products/small/';

        // Delete Product Small Image If exits in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Product Medium Image If exits in medium folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Product Large Image If exits in large folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //Delete Product Image From productsImage table
        ProductsImage::where('id',$id)->delete();

        $message = "Product Image Deleted Successfully!";
        return redirect()->back()->with('success_message',$message);

    }



    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::where('id', $id)->delete();
        $message = "Product Attribute Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }




}
