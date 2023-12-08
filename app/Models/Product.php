<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public static function productsFilters(){
        $productsFilters['laptopArray']=array('Dell','Hp','Lenove','Acer'); //fabric
        $productsFilters['computerArray']=array('Dell','Compace','Samsung','IBM');  //sleeve
        $productsFilters['mobileArray']=array('Samsung','Oppo','Mi','Iphone','Nokia','Motorola'); //pattern
        $productsFilters['companyArray']=array('Apple','Microsoft','Samsung','Dell','Nokia','Hp'); //fit
        $productsFilters['networkArray']=array('NTC','Ncell','Worldlink','Subisu','Vianet');  //occasion
        return $productsFilters;
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }
}
