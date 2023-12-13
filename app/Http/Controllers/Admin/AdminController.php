<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

// use Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        $categoriesCount = Category::get()->count();
        $productCount = Product::get()->count();
        $brandCount = Brand::get()->count();
        $userCount = Admin::where('type','subadmin')->get()->count();
        return view('admin.dashboard')->with(compact('categoriesCount','productCount','brandCount','userCount'));
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo'<pre>'; print_r($data);die;

            //rules
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30',
            ];

            $customMessages = [
                'email.required' => 'Email Required',
                'email.email' => 'Valid Email Required',
                'password.required' => 'Password Required',
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                if (Auth::guard('admin')->user()->status == 1) {
                    //Remember Admin email & password with cookie
                    if (isset($data['remember']) && !empty($data['remember'])) {
                        setcookie("email", $data["email"], time() + 7200);
                        setcookie("password", $data["password"], time() + 7200);
                    } else {
                        setcookie("email", "");
                        setcookie("password", "");
                    }

                    return redirect("admin/dashboard");
                } else {
                    return redirect()->back()->with("error_message", "Inactive User! Consult With Admin!");
                }
            } else {
                return redirect()->back()->with("error_message", "Invalid Email or Password");
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword(Request $request)
    {
        Session::put('page', 'update-password');
        $data = $request->all();
        if ($request->isMethod('post')) {
            $rules = [
                'new_pwd' => ['required','min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                ],
            ];

            $customMessages = [
                'new_pwd.required' => 'New Password Required',
                'new_pwd.min' => 'Password Must Be 8 Character',
                'new_pwd.regex' => 'Password Must Contain Upper-Lower Case, Number & Special Character',
            ];

            $this->validate($request, $rules, $customMessages);

            //check if the Current Password  is correct
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                //check if the new password and confirm password is matching
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    //Update the password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message', 'Password Update SuccessFul');
                } else {
                    return redirect()->back()->with('error_message', 'New Password & Confirm Password Not Match!');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your Current Password is Incorrect');
            }
        }
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }

    }

    public function updateDetails(Request $request)
    {
        Session::put('page', 'update-detail');
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo'<pre>'; print_r($data);die;

            //rules
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
                'admin_mobile' => 'required|numeric|digits:10',
                'admin_image' => 'image',
            ];

            $customMessages = [
                'admin_name.required' => 'Name Required',
                'admin_name.regex' => 'Valid Name Required',
                'admin_name.max' => 'Max Name 30 Character',
                'admin_mobile.required' => 'Mobile Required',
                'admin_mobile.digits' => 'Max Mobile Number 10 Digits',
                'admin_image.image' => 'Valid Image Required',
            ];

            $this->validate($request, $rules, $customMessages);

            //Upload Admin Image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                    $image_path = 'admin/images/photos/' . $imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            } else if (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = '';
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'],
                'mobile' => $data['admin_mobile'], 'image' => $imageName]);

            return redirect()->back()->with('success_message', 'Admin Detail Updated Sucessfully!');

        }
        return view('admin.update_details');
    }

    public function subadmins()
    {
        Session::put('page', 'subadmins');

        $subadmins = Admin::where('type', 'subadmin')->get();
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }

    public function updateSubadminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'subadmin_id' => $data['subadmin_id']]);
        }
    }

    public function addEditSubadmin(Request $request, $id = null)
    {
        $data = $request->all();
        // dd($data); die;

        if ($id == "") {
            $title = "Add Subadmin";
            $subadmindata = new Admin;
            $message = "Subadmin Added Successfully!";
        } else {
            $title = "Edit Subadmin";
            $subadmindata = Admin::find($id);
            $message = "Sub Admin updated Successfully!";
        }

        if ($request->isMethod('post')) {

            $rules = [
                'name' => 'required|max:255',
                'mobile' => 'required|numeric',
                'image' => 'image',
            ];

            $customMessages = [
                'name.required' => 'Name Required',
                'name.max' => 'Name Max Character 255 Exceed',
                'mobile.required' => 'Mobile Required',
                'mobile.numeric' => 'Valid Mobile Required',
                'image.image' => 'Valid Image required',

            ];

            if ($id == '') {
                $additional_rules = [
                    'email' => 'required',
                    'password' => 'required',
                ];
                $additional_customMessages = [
                    'email.required' => 'Email Required',
                    'password.required' => 'Password Required',
                ];

                $rules = array_merge($rules, $additional_rules);
                $customMessages = array_merge($customMessages, $additional_customMessages);
            }

            $this->validate($request, $rules, $customMessages);

            if ($id == "") {
                $subadminCount = Admin::where('email', $data['email'])->count();
                if ($subadminCount > 0) {
                    return redirect()->back()->with('error_message', 'Subadmin Email Already Exists!');
                }
            }

            //Upload Subadmin Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = date('Y-m-d') . '_' . rand(111, 99999) . '.' . $extension;
                    $image_path = 'admin/images/photos/' . $imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            } else if (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = '';
            }

            $subadmindata->name = $data['name'];
            $subadmindata->mobile = $data['mobile'];
            $subadmindata->image = $imageName;

            if ($id == "") {
                $subadmindata->email = $data['email'];
                $subadmindata->type = "subadmin";
                $subadmindata->status = 0;
            }

            if ($data['password'] != "") {
                $subadmindata->password = bcrypt($data['password']);
            }
            $subadmindata->save();
            return redirect('admin/subadmins')->with('success_message', $message);
        }

        return view('admin.subadmins.add_edit_subadmin')->with(compact('title', 'subadmindata'));

    }

    public function deleteSubadmin($id)
    {
        //delete subadmin
        Admin::where('id', $id)->delete();
        $message = "Subadmin Deleted Sucessfully";
        return redirect()->back()->with("success_message", $message);
    }

    public function updateRole(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data); die;

            //Delete all the previous role for the Subadmin
            AdminsRole::where('subadmin_id', $id)->delete();

            //add new roles for subadmin dynamically
            foreach ($data as $key => $value) {
                echo '<pre>';
                print_r($key);
                print_r($value);
                if (isset($value['view'])) {
                    $view = $value['view'];
                } else {
                    $view = 0;
                }
                if (isset($value['edit'])) {
                    $edit = $value['edit'];
                } else {
                    $edit = 0;
                }
                if (isset($value['full'])) {
                    $full = $value['full'];
                } else {
                    $full = 0;
                }

                if($key != "_token" && $key != "subadmin_id"){
                    $role = new AdminsRole;
                    $role->subadmin_id = $id;
                    $role->module = $key;
                    $role->view_access = $view;
                    $role->edit_access = $edit;
                    $role->full_access = $full;
                    $role->save();
                }

                // AdminsRole::where('subadmin_id',$id)->insert(['subadmin_id'=>$id, 'module'=>$key, 'view_access'=>$view, 'edit_access'=>$edit, 'full_access'=>$full ]);
            }


            $message = "Sub-Admin Roles & Permission Updated Sucessfully! ";
            return redirect()->back()->with('success_message', $message);

        }

        $subadminDetails = Admin::where('id',$id)->first()->toArray();
        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
        $title = "Update ".$subadminDetails['name']." Sub Admin Roles/Permission";
        // dd($subadminRoles);

        return view('admin.subadmins.update_roles')->with(compact('title', 'id', 'subadminRoles'));
    }

}
