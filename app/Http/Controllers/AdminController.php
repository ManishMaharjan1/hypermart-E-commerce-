<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Order;
use App\Product;
use App\Coupon;
use App\Category;
use App\Banner;
use App\Admin;
use illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function login(Request $request){
      if($request->isMethod('post')){
          $data = $request->input();
          $adminCount = Admin::where(['username' => $data['username'],'password' => md5($data['password']),'status' => '1'])->count();
          if($adminCount > 0){
           //echo "Success"; die;
          Session::put('adminSession',$data['username']);
          return redirect('admin/dashboard');
          }else{
           //echo "Failed"; die;
          return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
        }
      }
      return view('admin.admin_login');
    }
    public function dashboard($id=null){
      $userCount = User::paginate();
      $orderCount = Order::paginate();
      $productsAll = Product::paginate();
      $couponCount = Coupon::paginate();
      $categoryCount = Category::paginate();
      $bannerCount = Banner::paginate();
      /*if(Session::has('adminSession')){
        //perform all dashboard taks
      }else{
        return redirect('/admin')->with('flash_message_error','Please login to Success');
      }*/
      return view('admin.dashboard')->with(compact('userCount','orderCount','productsAll','couponCount','categoryCount','bannerCount'));
    }

    public function settings(){
      $adminDetails = Admin::where(['username' => Session::get('adminSession')])->first();
      return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkpassword(Request $request){
      $data = $request->all();
      $adminCount = Admin::where(['username' => Session::get('adminSession'),'password' => md5($data['current_pwd'])])->count();
      if($admincount == 1){
        echo "true";die;
      }else{
        echo "false";die;
      }
    }

    public function updatePassword(Request $request){
      if($request->isMethod('post')){
        $data =  $request->all();
        $adminCount = Admin::where(['username' => Session::get('adminSession'),'password' => md5($data['current_pwd'])])->count();
        if($admincount == 1){
          $password = md5($data['new_pwd']);
          Admin::where('username',Session::get('adminSession'))->update(['password'=>$password]);
          return redirect('/admin/settings')->with('flash_message_success','Password updated successfully.');
        }else{
          return redirect('/admin/settings')->with('flash_message_error','Current Password entered is incorrect.');
        }
      }
    }
    
    public function logout(){
      Session::flush();
      return redirect('/admin')->with('flash_message_success','Logged Out Successfully!!!');
    }
}
