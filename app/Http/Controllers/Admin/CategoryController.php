<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with('parentcategory')->get();

        //Set Admin/SubAdmins Permissions for Categories
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

        return view('admin.categories.categories')->with(compact('categories', 'categoriesModule'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();
        $message = "Category Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }

    public function addEditCategory(Request $request, $id = null)
    {

        $getCategories = Category::getCategories();

        if ($id == null) {
            $title = "Add Category";
            $category = new Category();
            $message = "Category Added Successfuly!";
        } else {
            $title = "Edit Category";
            $category = Category::find($id);
            $message = "Category Updated Successfully!";
        }

        //Set Admin/SubAdmins Permissions for Categories
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

        if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1) {

            if ($request->isMethod('post')) {
                $data = $request->all();
                // dd($data);die;

                if ($id == "") {
                    $rules = [
                        'category_name' => 'required',
                        'url' => 'required|unique:categories',
                    ];
                } else {
                    $rules = [
                        'category_name' => 'required',
                        'url' => 'required',
                    ];
                }

                $customMessages = [
                    'category_name.required' => 'Category Name Required!',
                    'url.required' => 'Category Url Required',
                    'url.unique' => 'Category Url Already Taken',
                ];

                $this->validate($request, $rules, $customMessages);


                //Upload Category Image
                if ($request->hasFile('category_image')) {

                    //delete the previous image from the folder
                    $previous_image = $category->category_image;
                    if(!empty($previous_image)){
                        $category_image_path = "front/images/categories/";
                        //Delete Previous Category Image If Exist
                        if(file_exists($category_image_path.$previous_image)){
                            unlink($category_image_path.$previous_image);
                        }
                    }

                    //Add new Category Image
                    $image_tmp = $request->file('category_image');
                    if ($image_tmp->isValid()) {
                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                        $image_path = 'front/images/categories/' . $imageName;
                        //Upload Category Image
                        Image::make($image_tmp)->save($image_path);
                    }
                } elseif (!empty($data['current_image'])) {
                    $imageName = $data['current_image'];
                } else {
                    $imageName = '';
                }

                if (empty($data['category_discount'])) {
                    $data['category_discount'] = 0;
                }

                $category->category_name = $data['category_name'];
                $category->parent_id = $data['parent_id'];
                $category->category_discount = $data['category_discount'];
                $category->description = $data['description'];
                $category->url = $data['url'];
                $category->meta_title = $data['meta_title'];
                $category->meta_description = $data['meta_description'];
                $category->meta_keywords = $data['meta_keywords'];
                $category->status = 1;
                $category->category_image = $imageName;
                $category->save();

                return redirect('admin/categories')->with('success_message', $message);

            }
        } else {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        }
        return view('admin.categories.add_edit_category')->with(compact('title', 'getCategories', 'category'));
    }

    public function deleteCategoryImage($id)
    {
        //Get Category Image
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        //Get Category Image Path
        $category_image_path = 'front/images/categories/';

        //Delete Category Image from Categories Folder If Exists
        if (file_exists($category_image_path . $categoryImage->category_image)) {
            unlink($category_image_path . $categoryImage->category_image);
        }

        //Delete Category image from categories table
        Category::where('id', $id)->update(['category_image' => '']);

        return redirect()->back()->with('success_message', 'Category Image Deleted Successfully!');
    }
}
