<?php

use App\Http\Controllers\Admin\CmsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get','post'],'login','AdminController@login');
    //if the admin is logged in the onlu other route can be explore
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard');
        Route::match(['get','post'],'update-password','AdminController@updatePassword');
        Route::match(['get','post'],'update-details','AdminController@updateDetails');
        Route::post('check-current-password','AdminController@checkCurrentPassword');
        Route::get('logout','AdminController@logout');

        //cms pages routing
        Route::get('cms-pages','CmsController@index');
        Route::post('update-cms-page-status','CmsController@update');
        Route::match(['get','post'],'add-edit-cms-page/{id?}','CmsController@edit');
        Route::get('delete-cms-page/{id?}','CmsController@destroy');

        //subadmins routing
        Route::get('subadmins','AdminController@subadmins');
        Route::post('update-subadmin-status','AdminController@updateSubadminStatus');
        Route::match(['get','post'],'add-edit-subadmin/{id?}','AdminController@addEditSubadmin');
        Route::get('delete-subadmin/{id?}','AdminController@deleteSubadmin');
        Route::match(['get','post'],'update-role/{id}','AdminController@updateRole');

        //Category
        Route::get('categories','CategoryController@categories');

    });
});
