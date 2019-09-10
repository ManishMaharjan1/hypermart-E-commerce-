<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;

class MenuController extends Controller
{
    public function addMenu(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>"; print_r($data); die;
            
            $menu = new Menu;
            $menu->name = $data['menu_name'];

            $menu->save();
            return redirect('/admin/view-menus')->with('flash_message_success','Menu Added Successfully!!!');
        }
        return view('admin.menu.add_menu');
    }

    public function viewMenus(){
        //Dynamically Display 
        $menus = Menu::get();
        return view('admin.menu.view_menus')->with(compact('menus'));
    }

    public function editMenu(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            Menu::where(['id'=>$id])->update(['name'=>$data['menu_name']]);
            return redirect('/admin/view-menus')->with('flash_message_success','Menu Updated Successfully!!!');
        }
        $menuDetails = Menu::where(['id'=>$id])->first();
        return view('admin.menu.edit_menu')->with(compact('menuDetails'));
    }

    public function deleteMenu($id=null){
    Menu::where(['id'=>$id])->delete();
    return redirect()->back()->with('flash_message_error','Menu has been deleted Successfully!!!');
    }
    
    public function delMenu(Request $request){
        $delId = $request->input('delId');
        Menu::whereIn('id',$delId)->delete();
        return redirect()->back()->with('flash_message_error','Selected Menu has been deleted Successfully!!!');
    }
}
