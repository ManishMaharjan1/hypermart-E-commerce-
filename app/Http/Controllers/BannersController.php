<?php

namespace App\Http\Controllers;

use DB;
use Image;
use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class BannersController extends Controller
{
    //function for add banner
    public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>"; print_r($data); die;
            
            $banner = new Banner;
            $banner->publication_status = $data['publication_status'];
            //upload image code
            if($request->hasfile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                //Image File Pat code
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $banner_image_path = 'images/backend_img/banners/'.$filename;
                //image resize code
                Image::make($image_tmp)->fit(1140,340)->save($banner_image_path);
                //Store img name in banner table
                $banner->image = $filename;
                }
            }
            $banner->save();
            return redirect('/admin/view-banners')->with('flash_message_success','Banner Added Successfully!!!');
        }
        return view('admin.banners.add_banner');
    }    
    //function for view banner
    public function viewBanners(){
        //Dynamically Display 
        $banners = Banner::get();
            return view('admin.banners.view_banner')->with(compact('banners'));
    }

    public function inactive_banner($id)
    {
        DB::table('banners')
                ->where('id' , $id)
                ->update(['publication_status' => 0]);
        return redirect('/admin/view-banners')->with('flash_message_success','Banner Inactive successfully !!');
    }

    public function active_banner($id)
    {
        DB::table('banners')
                ->where('id', $id)
                ->update(['publication_status' => 1]);
        return redirect('/admin/view-banners')->with('flash_message_success','Banner Active successfully !!');       
    }

    public function deleteBanner($id=null){
    Banner::where(['id'=>$id])->delete();
    return redirect()->back()->with('flash_message_error','Banner has been deleted Successfully!!!');
    }
}

