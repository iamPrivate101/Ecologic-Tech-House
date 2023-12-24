<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems(){
        if(Auth::check()){
            //If The User Is Logged In , Check From Auth (user_id)
            $user_id = Auth::user()->id;
            $getCartItems = Cart::with('product')->where('user_id',$user_id)->get()->toArray();
        }else{
            //If The User Is NOT-Logged In , Check From Session (session_id)
            $session_id = Session::get('session_id');
            $getCartItems = Cart::with('product')->where('session_id',$session_id)->get()->toArray();
        }

        return $getCartItems;

    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id')->with('brand','images');
    }
}
