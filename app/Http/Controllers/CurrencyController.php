<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function addCurrency(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>"; print_r($data); die;
            
            $currency = new Currency;
            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $data['exchange_rate'];
            $currency->publication_status = $data['publication_status'];

            $currency->save();
            return redirect('/admin/view-currencies')->with('flash_message_success','Currency Added Successfully!!!');
        }
        return view('admin.currency.add_currencies');
    }

    public function viewCurrencies(){
        //Dynamically Display 
        $currencies = Currency::get();
        return view('admin.currency.view_currencies')->with(compact('currencies'));
    }

    public function editCurrencies(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            Currency::where(['id'=>$id])->update(['currency_code'=>$data['currency_code'],'exchange_rate'=>$data['exchange_rate']]);
            return redirect('/admin/view-currencies')->with('flash_message_success','Currencies Updated Successfully!!!');
        }
        $currencyDetails = Currency::where(['id'=>$id])->first();
        return view('admin.currency.edit_currencies')->with(compact('currencyDetails'));
    }
    
    public function inactive_currency($id)
    {
        DB::table('currencies')
                ->where('id' , $id)
                ->update(['publication_status' => 0]);
        return redirect('/admin/view-currencies')->with('flash_message_success','Currency Inactive successfully !!');
    }

    public function active_currency($id)
    {
        DB::table('currencies')
                ->where('id', $id)
                ->update(['publication_status' => 1]);
        return redirect('/admin/view-currencies')->with('flash_message_success','Currency Active successfully !!');       
    }

    public function deleteCurrency($id=null){
    Currency::where(['id'=>$id])->delete();
    return redirect()->back()->with('flash_message_error','Currency has been deleted Successfully!!!');
    }
}
