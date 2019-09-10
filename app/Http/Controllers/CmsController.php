<?php

namespace App\Http\Controllers;

use DB;
use App\CmsPage;
use App\Category;
use Validator;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function addCmsPages(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>"; print_r($data); die;
            
            $cmspage = new CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->description = $data['description'];
            $cmspage->url = $data['url'];
            $cmspage->publication_status = $data['publication_status'];

            $cmspage->save();
            return redirect('/admin/view-cmspages')->with('flash_message_success','CmsPage Added Successfully!!!');
        }
        return view('admin.cms.add_cmspage');
    }

    public function viewCmspages(){
        //Dynamically Display 
        $cmspages = CmsPage::get();
            return view('admin.cms.view_cmspages')->with(compact('cmspages'));
    }

    public function editCmsPages(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            CmsPage::where(['id'=>$id])->update(['title'=>$data['title'],'description'=>$data['description'],'url'=>$data['url']]);
            return redirect('/admin/view-cmspages')->with('flash_message_success','CmsPage Updated Successfully!!!');
        }
        $cmsDetails = CmsPage::where(['id'=>$id])->first();
        return view('admin.cms.edit_cmspage')->with(compact('cmsDetails'));
    }

    public function inactive_cmspages($id)
    {
        DB::table('cms_pages')
                ->where('id' , $id)
                ->update(['publication_status' => 0]);
        return redirect('/admin/view-cmspages')->with('flash_message_success','CmsPage Inactive successfully !!');
    }

    public function active_cmspages($id)
    {
        DB::table('cms_pages')
                ->where('id', $id)
                ->update(['publication_status' => 1]);
        return redirect('/admin/view-cmspages')->with('flash_message_success','CmsPage Active successfully !!');       
    }

    public function deleteCmspages($id=null){
        CmsPage::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_error','CmsPage has been deleted Successfully!!!');
    }

    public function delCmspages(Request $request){
        $delId = $request->input('delId');
        CmsPage::whereIn('id',$delId)->delete();
        return redirect()->back()->with('flash_message_error','Selected CmsPage has been deleted Successfully!!!');
    }

    public function cmsPage($url)
    {
        //Check if CMS page is inactive or does not exists
        $cmsPageCount = CmsPage::where(['url'=>$url,'publication_status' => 1])->count();
        if($cmsPageCount>0){
            //get cms page details
            $cmsPageDetails = CmsPage::where('url',$url)->first();

        }else{
            abort(404);
        }

        //Get CMS page details
        $cmsPageDetails = CmsPage::where('url',$url)->first();
        //Get all categories ansd sub categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        return view('pages.cms_page')->with(compact('cmsPageDetails','categories'));
    }

    public function contact(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            $validator = Validator::make($request->all(),[
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'subject' => 'required',
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //Send Contact email
            $email = "rageme95@gmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message'],
            ];
            Mail::send('email.enquiry',$messageData,function($message)use($email){
                $message->to($email)->subject('Enquiry from Hypermart Website');
            });

            return redirect()->back()->with('flash_message_success','Thanks for your enquiry. We will get back to you soon.');

        }    
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        return view('pages.contact')->with(compact('categories'));;
    }
}