<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;

class Product extends Model
{
    public function attributes(){
        return $this->hasMany('App\ProductsAttribute','product_id');
    }
    public function colors(){
        return $this->hasMany('App\ProductsColor','product_id');
    }
    
    public function scopeSearch($query , $s){
        return $query->where('product_name','like','%'.$s.'%')->orWhere('description','like','%'.$s.'%');

    }

    public static function cartCount(){
		if(Auth::check()){
			/*echo "User is logged in. We will use Auth";*/
			$user_email = Auth::user()->email;
			$cartCount =  DB::table('cart')->where('user_email',$user_email)->sum('quantity');
		}else{
			// echo "User is not loggd in. We will use Session";
			$session_id = Session::get('session_id');
			$cartCount =  DB::table('cart')->where('session_id',$session_id)->sum('quantity');
		}
		return $cartCount;
	}
	public static function productCount($cat_id){
		$catCount = Product::where(['category_id'=>$cat_id,'publication_status'=>1])->count();
		return $catCount;
	}

    public static function getCurrencyRates($price){
        $getCurrencies = Currency::where('publication_status',1)->get();
        foreach($getCurrencies as $currency){
            if($currency->currency_code == "USD"){
                $USD_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == "GBP"){
                $GBP_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == "EURO"){
                $EURO_Rate = round($price/$currency->exchange_rate,2);
            }  
        }
        $currenciesArr =  array('USD_Rate' => $USD_Rate,'GBP_Rate' => $GBP_Rate,'EURO_Rate' => $EURO_Rate);
        return $currenciesArr;
    }

    public static function getProductStock($product_id,$product_size){
        $getProductStock = ProductsAttribute::select('stock')->where(['product_id' => $product_id,'size' => $product_size ])->first();
        return $getProductStock->stock;
    }
}
