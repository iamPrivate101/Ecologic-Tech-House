<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Product;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get();

        //Set Admin/SubAdmins Permissions for Banners
        $bannersModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->count();
        $bannersModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $bannersModule['view_access'] = 1;
            $bannersModule['edit_access'] = 1;
            $bannersModule['full_access'] = 1;
        } else if ($bannersModuleCount == 0) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $bannersModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->first()->toArray();
        }

        return view('admin.banners.banners')->with(compact('banners','bannersModule'));
    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
        //GEt Banner Image
        $bannerImage = Banner::where('id',$id)->first();
        //Get Image Path
        $banner_image_path = "front/images/banners/";
        //Delete Banner Image If Exist
        if(file_exists($banner_image_path.$bannerImage)){
            unlink($banner_image_path.$bannerImage);
        }

        //Delete Banner Image from Banner table
        Banner::where('id', $id)->delete();
        $message = "Banner Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }

    public function addEditBanner(Request $request, $id = null)
    {
        if ($id == null) {
            $title = "Add Banner";
            $banner = new Banner();
            $message = "Banner Added Successfuly!";
        } else {
            $title = "Edit Banner";
            $banner = Banner::find($id);
            $message = "Banner Updated Successfully!";
        }

        //Set Admin/SubAdmins Permissions for Banners
        $bannersModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->count();
        $bannersModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $bannersModule['view_access'] = 1;
            $bannersModule['edit_access'] = 1;
            $bannersModule['full_access'] = 1;
        } else if ($bannersModuleCount == 0) {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $bannersModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->first()->toArray();
        }

        if ($bannersModule['edit_access'] == 1 || $bannersModule['full_access'] == 1) {

            if ($request->isMethod('post')) {
                $data = $request->all();
                // dd($data);die;

                if ($id == "") {
                    $rules = [
                        'type' => 'required',
                        'banner_image' => 'required',
                    ];
                } else {
                    $rules = [
                        'type' => 'required',
                        // 'banner_image' => 'required',
                    ];
                }

                $customMessages = [
                    'type.required' => 'Banner Type Required!',
                    'banner_image.required' => 'Banner Image Required',
                ];

                $this->validate($request, $rules, $customMessages);

                //Upload Banner Image
                if ($request->hasFile('banner_image')) {
                    $image_tmp = $request->file('banner_image');
                    if ($image_tmp->isValid()) {
                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                        $image_path = 'front/images/banners/' . $imageName;
                        //Upload Banner Image
                        Image::make($image_tmp)->save($image_path);
                        $banner->image = $imageName;
                    }
                } else if (!empty($data['current_image'])) {
                    $imageName = $data['current_image'];
                    $banner->image = $imageName;
                } else {
                    $imageName = '';
                    $banner->image = $imageName;
                }


                $banner->title = $data['title'];
                $banner->alt = $data['alt'];
                $banner->link = $data['link'];
                $banner->sort = $data['sort'];
                $banner->type = $data['type'];
                $banner->status = 1;
                $banner->save();

                return redirect('admin/banners')->with('success_message', $message);

            }
        } else {
            $message = "This Feature is Restricted For You";
            return redirect('admin/dashboard')->with('error_message', $message);
        }
        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }


}
