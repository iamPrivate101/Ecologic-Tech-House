<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parentcategory(){
        return $this->hasOne('App\Models\Category','id','parent_id')->select('id','category_name','url')->where('status',1);
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public static function getCategories(){
        $getCategories = Category::with(['subcategories'=>function($query){
            $query->with('subcategories');
        }])->where('parent_id',0)->where('status',1)->get()->toArray();
        // dd($getCategories);
        return $getCategories;
    }
}
