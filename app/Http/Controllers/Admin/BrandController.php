<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands()
    {
        Session::put('page', 'brands');
        $brands = Brand::get();

        //Set Admin/SubAdmins Permissions for Brands
        $brandsModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->count();
        $brandsModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $brandsModule['view_access'] = 1;
            $brandsModule['edit_access'] = 1;
            $brandsModule['full_access'] = 1;
        } else if ($brandsModuleCount == 0) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $brandsModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->first()->toArray();
        }

        return view('admin.brands.brands')->with(compact('brands','brandsModule'));
    }

    public function updateBrandStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'brand_id' => $data['brand_id']]);
        }
    }

    public function deleteBrand($id)
    {
        Brand::where('id', $id)->delete();
        $message = "Brand Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }

    public function addEditBrand(Request $request, $id = null)
    {
        if ($id == null) {
            $title = "Add Brand";
            $brand = new Brand();
            $message = "Brand Added Successfuly!";
        } else {
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand Updated Successfully!";
        }

        //Set Admin/SubAdmins Permissions for Brands
        $brandsModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->count();
        $brandsModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $brandsModule['view_access'] = 1;
            $brandsModule['edit_access'] = 1;
            $brandsModule['full_access'] = 1;
        } else if ($brandsModuleCount == 0) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $brandsModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->first()->toArray();
        }

        if ($brandsModule['edit_access'] == 1 || $brandsModule['full_access'] == 1) {

            if ($request->isMethod('post')) {
                $data = $request->all();
                // dd($data);die;

                if ($id == "") {
                    $rules = [
                        'brand_name' => 'required',
                        'url' => 'required|unique:brands',
                    ];
                } else {
                    $rules = [
                        'brand_name' => 'required',
                        'url' => 'required',
                    ];
                }

                $customMessages = [
                    'brand_name.required' => 'Brand Name Required!',
                    'url.required' => 'Brand Url Required',
                    'url.unique' => 'Brand Url Already Taken',
                ];

                $this->validate($request, $rules, $customMessages);

                //Upload Brand Image
                if ($request->hasFile('brand_image')) {

                    //delete the previous image from the folder
                    $previous_image = $brand->brand_image;
                    if(!empty($previous_image)){
                        $brands_image_path = "front/images/brands/";
                        //Delete Brand Image If Exist
                        if(file_exists($brands_image_path.$previous_image)){
                            unlink($brands_image_path.$previous_image);
                        }
                    }

                    //add new brand images
                    $image_tmp = $request->file('brand_image');
                    if ($image_tmp->isValid()) {
                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                        $image_path = 'front/images/brands/' . $imageName;
                        //Upload Brand Image
                        Image::make($image_tmp)->save($image_path);
                        $brand->brand_image = $imageName;
                    }
                } else if (!empty($data['current_image'])) {
                    $imageName = $data['current_image'];
                    $brand->brand_image = $imageName;
                } else {
                    $imageName = '';
                    $brand->brand_image = $imageName;
                }


                //Upload Brand Logo
                if ($request->hasFile('brand_logo')) {

                    //delete the previous image logo from the folder
                    $previous_logo = $brand->brand_logo;
                    if(!empty($previous_logo)){
                        $brands_logo_path = "front/images/brands/";
                        //Delete Banner Image If Exist
                        if(file_exists($brands_logo_path.$previous_logo)){
                            unlink($brands_logo_path.$previous_logo);
                        }
                    }

                    //add new brand logo
                    $image_tmp = $request->file('brand_logo');
                    if ($image_tmp->isValid()) {
                        //Get Logo Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Logo Name
                        $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                        $image_path = 'front/images/brands/' . $imageName;
                        //Upload Brand Logo
                        Image::make($image_tmp)->save($image_path);
                        $brand->brand_logo = $imageName;
                    }
                } else if (!empty($data['current_logo'])) {
                    $imageName = $data['current_logo'];
                    $brand->brand_logo = $imageName;
                } else {
                    $imageName = '';
                    $brand->brand_logo = $imageName;
                }


                //Remove Brand Discount from all the products belongs to specific brand
                if (empty($data['brand_discount'])) {
                    $data['brand_discount'] = 0;
                    if($id != ""){
                        $brandProducts = Product::where('brand_id',$id)->get()->toArray();
                        foreach($brandProducts as $key=>$product){
                            if($product['discount_type']=="brand"){
                                Product::where('id',$product['id'])->update(['discount_type'=>'', 'final_price'=>$product['product_price']]);
                            }
                        }
                    }
                }

                $brand->brand_name = $data['brand_name'];
                $brand->brand_discount = $data['brand_discount'];
                $brand->description = $data['description'];
                $brand->url = $data['url'];
                $brand->meta_title = $data['meta_title'];
                $brand->meta_description = $data['meta_description'];
                $brand->meta_keywords = $data['meta_keywords'];
                $brand->status = 1;
                $brand->save();

                return redirect('admin/brands')->with('success_message', $message);

            }
        } else {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        }
        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand'));
    }

    public function deleteBrandImage($id)
    {
        //Get Brand Image
        $brandImage = Brand::select('brand_image')->where('id', $id)->first();

        //Get Brand Image Path
        $brand_image_path = 'front/images/brands/';

        //Delete Brand Image from Brands Folder If Exists
        if (file_exists($brand_image_path . $brandImage->brand_image)) {
            unlink($brand_image_path . $brandImage->brand_image);
        }

        //Delete Brand image from brands table
        Brand::where('id', $id)->update(['brand_image' => '']);

        return redirect()->back()->with('success_message', 'Brand Image Deleted Successfully!');
    }

    public function deleteBrandLogo($id)
    {
        //Get Brand Logo
        $brandLogo = Brand::select('brand_logo')->where('id', $id)->first();

        //Get Brand Logo Path
        $brand_logo_path = 'front/images/brands/';

        //Delete Brand Logo from Brands Folder If Exists
        if (file_exists($brand_logo_path . $brandLogo->brand_logo)) {
            unlink($brand_logo_path . $brandLogo->brand_logo);
        }

        //Delete Brand image from brands table
        Brand::where('id', $id)->update(['brand_logo' => '']);

        return redirect()->back()->with('success_message', 'Brand Logo Deleted Successfully!');
    }
}
