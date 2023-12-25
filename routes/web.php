<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Admin\ProductsController;


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



Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/',[IndexController::class,'index']);

    //Listing / Categories Routes
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url');
    // dd($catUrls);
    foreach ($catUrls as $key => $url) {
        Route::get($url, 'ProductController@listing');
    }

    //Product Detail Page
    Route::get('product/{id?}',[ProductController::class,'detail']);

    //Get Product Attribute Price
    Route::post('get-attribute-price',[ProductController::class,'getAttributePrice']);

    //Add To Cart
    Route::post('add-to-cart',[ProductController::class,'addToCart']);

    //Shopping Cart
    Route::get('cart',[ProductController::class,'cart']);

    //Update Cart Item Quantity
    Route::post('update-cart-item-qty',[ProductController::class,'updateCartItemQty']);

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
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::get('delete-category/{id?}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id?}','CategoryController@deleteCategoryImage');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

        //Products
        // Route::get('products','ProductsController@products');
        //new style to route
        Route::get('products',[ProductsController::class,'products']);
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id?}','ProductsController@deleteProduct');
        // Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        //new way
        Route::match(['get','post'],'add-edit-product/{id?}',[ProductsController::class,'addEditProduct']);

        //Product Images
        Route::get('delete-product-image/{id?}','ProductsController@deleteProductImage');

        //Product Video
        Route::get('delete-product-video/{id?}','ProductsController@deleteProductVideo');

        //Product Attribute
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id?}','ProductsController@deleteAttribute');

        //Brands
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        Route::get('delete-brand/{id?}','BrandController@deleteBrand');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');
        Route::get('delete-brand-image/{id?}','BrandController@deleteBrandImage');
        Route::get('delete-brand-logo/{id?}','BrandController@deleteBrandLogo');

        //Banners
        Route::get('banners','BannerController@banners');
        Route::post('update-banner-status','BannerController@updateBannerStatus');
        Route::get('delete-banner/{id?}','BannerController@deleteBanner');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannerController@addEditBanner');













    });
});
