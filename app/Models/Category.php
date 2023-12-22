<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parentcategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id')->select('id', 'category_name', 'url')->where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }

    public static function getCategories()
    {
        $getCategories = Category::with(['subcategories' => function ($query) {
            $query->with('subcategories');
        }])->where('parent_id', 0)->where('status', 1)->get()->toArray();
        // dd($getCategories);
        return $getCategories;
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id', 'parent_id', 'category_name', 'url')->with('subcategories','parentcategory')->where('url', $url)->first()->toArray();
        // echo '<pre>'; print_r($categoryDetails); die;
        $catIds = array();
        $catIds[] = $categoryDetails['id'];
        foreach ($categoryDetails['subcategories'] as $subcat) {
            $catIds[] = $subcat['id'];
        }
        // print_r($catIds);die;

        if($categoryDetails['parent_id'] == 0){
            //Only Show Main Category In Breadcrumbs
            $breadcrumbs = '<a class="gl-tag btn--e-brand-shadow" href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }else{
            //Show Msin And Sub Categoryin Breadcrumbs
            $parentCategory = Category::select('category_name','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<a class="gl-tag btn--e-brand-shadow" href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>
             <a class="gl-tag btn--e-brand-shadow" href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';

        }
        return array('catIds' => $catIds, 'categoryDetails'=>$categoryDetails, 'breadcrumbs'=>$breadcrumbs );
    }
}
