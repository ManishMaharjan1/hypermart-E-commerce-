<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\ProductsColor;
use App\Coupon;
use DB;
use App\Banner;
use App\User;
use App\Country;
use App\Order;
use App\OrdersProduct;
use App\DeliveryAddress;

class ProductsController extends Controller
{
    public function addProduct(Request $request){
       //this code save product records in database
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if(empty($data['category_id'])){
            return redirect()->back()->with('flash_message_error','Under Category is Missing :(');    
            }
            $product = new Product;
            $product->category_id .= $data['category_id'];
            $product->product_name= $data['product_name'];
            $product->product_code = $data['product_code'];
            // $product->product_color = $data['product_color'];
            
            if(!empty($data['description'])){
            $product->description = $data['description'];
            }else{
            $product->description = '';
            }
            if(!empty($data['sleeve'])){
            $product->sleeve = $data['sleeve'];
            }else{
            $product->sleeve = '';
            }
            if(!empty($data['pattern'])){
            $product->pattern = $data['pattern'];
            }else{
            $product->pattern = '';
            }
            if(!empty($data['care'])){
                $product->care = $data['care'];
                }else{
                $product->care = '';
                }

            $product->price = $data['price'];
            //upload image code
            if($request->hasfile('image')){
                echo $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                //Image File Pat code
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $large_image_path = 'images/backend_img/products/large/'.$filename;
                $small_image_path = 'images/backend_img/products/small/'.$filename;
                $medium_image_path = 'images/backend_img/products/medium/'.$filename;
                //image resize code
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                //Store img name in products table
                $product->image = $filename; 
                }
            }
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success','Product has been Added Successfully!!!'); 
        }

        //this code genrate categories in drop box menu in add products page
        //categories drop down starts

        $categories = Category::where(['Parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->Name."</option>";
        //code for showing subcategories in main category
        $sub_categories = Category::where(['Parent_id'=>$cat->id])->get();
        foreach($sub_categories as $sub_cat){
        $categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->Name."</option>";
        }
    } //categories drop down end

        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');

        $patternArray = array('Checked','Plain','Printed','Self','Solid');

        return view('admin.products.add_product')->with(compact('categories_dropdown','sleeveArray','patternArray'));
    
    }
    //functions for view products
    public function viewProducts(Request $request){
        $products = Product::get();
        //$products = json_decode(json_encode('$products'));
        foreach($products as $key =>$val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->Name;
        }
        //echo "<pre>"; print_r($products);die;
        return view ('admin.products.view_products')->with(compact('products'));

    }
    //function for edit products
    public function editProduct(Request $request,$id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if(!empty($data['sleeve'])){
                $sleeve = $data['sleeve'];
            }else{
                $sleeve = '';
            }
            if(!empty($data['pattern'])){
                $pattern = $data['pattern'];
            }else{
                $pattern = '';
            }
            //upload image code
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                //Image File Path code
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $large_image_path = 'images/backend_img/products/large/'.$filename;
                $small_image_path = 'images/backend_img/products/small/'.$filename;
                $medium_image_path = 'images/backend_img/products/medium/'.$filename;
                //image resize code
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                Image::make($image_tmp)->resize(600,600)->save($medium_image_path); 
                }
            }else{
                $filename = $data['current_image']; 
            }
            if(empty($data['description'])){
                $data['description'] = '';
            }
            if(empty($data['care'])){
                $data['care'] = '';
            }

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],
            'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],
            'product_color'=>$data['product_color'],'description'=>$data['description'],
            'care'=>$data['care'],'price'=>$data['price'],'image'=>$filename,'sleeve'=>$sleeve,'pattern'=>$pattern]);
            return redirect()->back()->with('flash_message_success','Product has been Updated Successfully!!!');
        }
        $productDetails = Product::where(['id'=>$id])->first();
        //categories drop down starts

        $categories = Category::where(['Parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id==$productDetails->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->Name."</option>";
        //code for showing subcategories in main category
        $sub_categories = Category::where(['Parent_id'=>$cat->id])->get();
        foreach($sub_categories as $sub_cat){
            if($sub_cat->id==$productDetails->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
        $categories_dropdown .= "<option value = '".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->Name."</option>";
        }
    } 
    //categories drop down end
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');
        return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown','sleeveArray','patternArray')); 

    }
    //function for delete product
    public function deleteProduct($id=null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_error','Product has been deleted Successfully!!!');

    }

    public function delProduct(Request $request){
        $delId = $request->input('delId');
        Product::whereIn('id',$delId)->delete();
        return redirect()->back()->with('flash_message_error','Selected Product has been deleted Successfully!!!');
    }

    //function for delete product image
    public function deleteProductImage($id=null){
        //Get product image name
        $productImage = Product::where(['id'=>$id])->first();
        //echo $productImage->image;die;
        //Get product Image Path
        $large_image_path = 'images/backend_img/products/large/';
        $medium_image_path = 'images/backend_img/products/medium/';
        $small_image_path = 'images/backend_img/products/small/'; 
        //Delete Large image if not exist in folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        //Delete Medium image if not exist in folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        //Delete Small image if not exist in folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        //Delete Product Image in folder
        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Product Image has been deleted!');

    }
    public function deleteAltImage($id=null){
        //Get product image name
        $productImage = ProductsImage::where(['id'=>$id])->first();
        //echo $productImage->image;die;
        //Get product Image Path
        $large_image_path = 'images/backend_img/products/large/';
        $medium_image_path = 'images/backend_img/products/medium/';
        $small_image_path = 'images/backend_img/products/small/'; 
        //Delete Large image if not exist in folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        //Delete Medium image if not exist in folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        //Delete Small image if not exist in folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        //Delete Product Image in folder
        ProductsImage::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_error','Product Alternate Image has been deleted!');

    }
    //function for add-products attributes
    public function addAttributes(Request $request, $id=null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails);die;
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['sku'] as $key => $val ){
                if(!empty($val)){
                    //Prevent duplicate SKU check
                    $attrCountSKU = ProductsAttribute::where('sku',$val)->count();
                    if($attrCountSKU>0){
                    return redirect('/admin/add-attributes/'.$id)->with('flash_message_error','SKU is already exist please add another SKU!');   
                    }
                    //Prevent duplicate Size check
                    $attrCountSizes =ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSizes>0){
                    return redirect('/admin/add-attributes/'.$id)->with('flash_message_error',''.$data['size'][$key].' Size is already exist for this product please add another Size!');   
                    } 

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price =$data['price'][$key];
                    $attribute->stock =$data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success','Products Attributes Added Successfully!');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));

    }
    //function for edit-products attributes
    public function editAttributes(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>";print_r($data);die;
            foreach($data['idAttr'] as $key=>$attr){
                ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key],
                'stock'=>$data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success','Products Attributes Updated!!!');
        }

    }
    public function addImages(Request $request, $id=null){
        //this code genrates to store images in our database 
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        if($request->isMethod('post')){
          //Add alternative images
            $data = $request->all();
            if($request->hasfile('image')){
            $files = $request->file('image');
            foreach($files as $file){
            //Upload images after resize
            $image = new ProductsImage;
            $extension = $file->getClientOriginalExtension();
            $filename = rand(111,9999).'.'.$extension;
            $large_image_path = 'images/backend_img/products/large/'.$filename;
            $small_image_path = 'images/backend_img/products/small/'.$filename;
            $medium_image_path = 'images/backend_img/products/medium/'.$filename;
            //image resize code
            Image::make($file)->save($large_image_path);
            Image::make($file)->resize(300,300)->save($small_image_path);
            Image::make($file)->resize(600,600)->save($medium_image_path);
            $image->image = $filename;
            $image->product_id = $data['product_id'];
            $image->save();
            }
        } 
            return redirect('admin/add-images/'.$id)->with('flash_message_success','Product Images has been Updated Successfully!!!');
        }
        //this code is to display images in our add-images.blade file from db
        $productImages = ProductsImage::where(['product_id'=>$id])->get();
        
        return view('admin.products.add_images')->with(compact('productDetails','productImages'));

    }
    public function deleteAttribute($id=null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_error','Attribute has been deleted successfully!');
    
    }

    //function for add-products colors
    public function addColors(Request $request, $id=null){
        $productDetails = Product::with('colors')->where(['id'=>$id])->first();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails);die;
        if($request->isMethod('post')){
            $data = $request->all();
                foreach($data['product_color'] as $key => $val ){
                $color = new ProductsColor;
                $color->product_id = $id;
                $color->product_color = $val;
                $color->save();
            }
            return redirect('/admin/add-colors/'.$id)->with('flash_message_success','Products Colors Added Successfully!');
        }
        return view('admin.products.add_colors')->with(compact('productDetails'));

    }

    public function products($url=null){
        //Show 404 Page if category url does not exist
        $countCategory = Category::where(['url'=>$url, 'status'=>1])->count();
        if($countCategory==0){
            abort(404);
        }

        //Display Categories or Sub Categories in left Sidebar of Home Page
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        $categoryDetails = Category::where(['url'=> $url])->first();
        if($categoryDetails->Parent_id==0){
            //if url is Main category url
            $subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();
            foreach($subCategories  as $subcat){
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('category_id',$cat_ids)->get();
            $productsAll = json_decode(json_encode($productsAll));

            $breadcrumb = "<a href='/'>Home</a> / <a href=' ".$categoryDetails->url." '>".$categoryDetails->Name."</a>";
        }else{
            //if url is sub category url
            $productsAll = Product::where(['category_id'=>$categoryDetails->id])->get();
            $mainCategory = Category::where('id',$categoryDetails->Parent_id)->first();

            $breadcrumb = "<a href='/'>Home</a> / <a href=' ".$mainCategory->url." '>".$mainCategory->Name."</a> / <a href=' ".$categoryDetails->url." '>".$categoryDetails->Name."</a>";
        }

        if(!empty($_GET['color'])){
            $colorArray = explode('-',$_GET['color']);
            $productsAll = $productsAll->whereIn('product_color',$colorArray);
        }
            
        if(!empty($_GET['sleeve'])){
            $sleeveArray = explode('-',$_GET['sleeve']);
            $productsAll = $productsAll->whereIn('sleeve',$sleeveArray);
        }

        if(!empty($_GET['pattern'])){
            $patternArray = explode('-',$_GET['pattern']);
            $productsAll = $productsAll->whereIn('pattern',$patternArray);
        }

        if(!empty($_GET['size'])){
            $sizeArray = explode('-',$_GET['size']);
            $productsAll = Product::join('products_attributes','products_attributes.product_id','=','products.id')
                                    ->select('products.*','products_attributes.product_id','products_attributes.size')
                                    ->groupBy('products_attributes.product_id')
                                    ->whereIn('products_attributes.size',$sizeArray)
                                    ->get();
        }
        
        // $productsAll = $productsAll->paginate(5);
        // $colorArray = array('Black','Blue','Brown','White','Red','Yellow');
        $colorArray = Product::select('product_color')->groupBy('product_color')->get();
        $colorArray = array_flatten(json_decode(json_encode($colorArray),true));

        $sleeveArray = Product::select('sleeve')->where('sleeve','!=','')->groupBy('sleeve')->get();
        $sleeveArray = array_flatten(json_decode(json_encode($sleeveArray),true));

        $patternArray = Product::select('pattern')->where('pattern','!=','')->groupBy('pattern')->get();
        $patternArray = array_flatten(json_decode(json_encode($patternArray),true));

        $sizesArray = ProductsAttribute::select('size')->groupBy('size')->get();
        $sizesArray = array_flatten(json_decode(json_encode($sizesArray),true));

        $banners = Banner::where('publication_status','1')->get();
        
        return view('products.listing')->with(compact('categories','categoryDetails','productsAll','banners','breadcrumb','colorArray','url','sleeveArray','patternArray','sizesArray')); 
        
        
    }

    public function filter(Request $request)
    {
        $data= $request->all();

        $colorUrl="";
        if(!empty($data['colorFilter'])){
            foreach($data['colorFilter'] as $color){
                if(empty($colorUrl)){
                    $colorUrl ="&color=".$color;
                }else{
                    $colorUrl .= "-".$color;
                }
            }
        }

        $sleeveUrl="";
        if(!empty($data['sleeveFilter'])){
            foreach($data['sleeveFilter'] as $sleeve){
                if(empty($sleeveUrl)){
                    $sleeveUrl ="&sleeve=".$sleeve;
                }else{
                    $sleeveUrl .= "-".$sleeve;
                }
            }
        }

        $patternUrl="";
        if(!empty($data['patternFilter'])){
            foreach($data['patternFilter'] as $pattern){
                if(empty($patternUrl)){
                    $patternUrl ="&pattern=".$pattern;
                }else{
                    $patternUrl .= "-".$pattern;
                }
            }
        }

        $sizeUrl="";
        if(!empty($data['sizeFilter'])){
            foreach($data['sizeFilter'] as $size){
                if(empty($sizeUrl)){
                    $sizeUrl ="&size=".$size;
                }else{
                    $sizeUrl .= "-".$size;
                }
            }
        }

        $finalUrl = "products/".$data['url']."?".$colorUrl.$sleeveUrl.$patternUrl.$sizeUrl;
        return redirect::to($finalUrl);

        
        
    }

    public function product($id=null){
        $productDetails = Product::with('attributes')->where('id',$id)->first();
        $productDetails = json_decode(json_encode($productDetails));

        $productDetail = Product::with('colors')->where('id',$id)->first();
        $productDetail = json_decode(json_encode($productDetail));
        //echo "<pre>";print_r($productDetails);die;
         //Related Products Code
        $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
        //$relatedProducts = json_decode(json_encode($relatedProducts));
        /* foreach($relatedProducts->chunk(3) as $chunk){
            foreach($chunk as $item){
                echo $item; echo"<br>";
            }
            echo "<br><br><br>";
        }
        die;*/
        //echo "<pre>";print_r($relatedProducts);die;

        //Display Categories or Sub Categories in left Sidebar of Home Page
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        $categoryDetails = Category::where('id',$productDetails->category_id)->first();

        if($categoryDetails->Parent_id==0){
            $breadcrumb = "<a href='/'>Home</a> / <a href=' ".$categoryDetails->url." '>".$categoryDetails->Name."</a> / ".$productDetails->product_name;
        }else{
            //if url is sub category url
            $mainCategory = Category::where('id',$categoryDetails->Parent_id)->first();
            $breadcrumb = "<a style='color:#333;' href='/'>Home</a> / <a style='color:#333;' href='/products/".$mainCategory->url." '>".$mainCategory->Name."</a> / <a style='color:#333;' href='/products/".$categoryDetails->url." '>".$categoryDetails->Name."</a> / " .$productDetails->product_name;
        }

        //Get products alternate images
        $productAltimages =ProductsImage::where('product_id',$id)->get();
        /*$productAltimages = json_decode(json_encode($productAltimages));
        echo "<pre>";print_r($productAltimages);die;*/
        
        $total_stock = ProductsAttribute:: where('product_id',$id)->sum('stock');  

        return view('products.detail')->with(compact('productDetails','categories','productAltimages','total_stock','relatedProducts','breadcrumb','productDetail'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        $getCurrencyRates = Product::getCurrencyRates($proAttr->price);
        echo $proAttr->price ." - ". $getCurrencyRates['USD_Rate'] ." - ". $getCurrencyRates['GBP_Rate'] ." - ". $getCurrencyRates['EURO_Rate'];
        echo "#";
        echo $proAttr->stock;

    }
    public function addtocart(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        //echo "<pre>";print_r($data);

        // Select size error 
        if(empty($data['size'])){
            return redirect()->back()->with('flash_message_error','Please Provide Your Size ');
        }

        //Select color error
        if(empty($data['product_color'])){
            return redirect()->back()->with('flash_message_error','Please Choose Your Color');
        }

        // Check Product Stock is available or not
        $product_size = explode("-",$data['size']);
        $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'],'size' =>$product_size[1]])->first();
        if($getProductStock->stock<$data['quantity']){
            return redirect()->back()->with('flash_message_error','Required Quantity is not available!!');
        }

        if(empty(Auth::user()->email)){
            $data['user_email'] = '';
        }else{
            $data['user_email'] = Auth::user()->email;
        }
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = str_random(40);
            Session::put('session_id',$session_id);
        }

        // if(empty($data['size'])){
        //     return redirect()->back()->with('flash_message_error','Please Provide Your Size ');
        // }
        $sizeArr = explode("-",$data['size']);
        $product_size = $sizeArr[1];

        $colorArr = explode("-",$data['product_color']);
        $product_color = $colorArr[1];

        if(empty(Auth::check())){
            $countProducts =DB::table('cart')->where(['product_id'=>$data['product_id'],
            'product_color'=>$product_color,'size'=>$product_size,'session_id'=>$session_id])->count();
            if($countProducts>0){
            return redirect()->back()->with('flash_message_error','Product already exists in Cart!!');
            }
        }else{
            $countProducts =DB::table('cart')->where(['product_id'=>$data['product_id'],
            'product_color'=>$product_color,'size'=>$product_size,'user_email'=>$data['user_email']])->count();
            if($countProducts>0){
            return redirect()->back()->with('flash_message_error','Product already exists in Cart!!');
            }
        }
        
        $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],
            'size'=>$product_size])->first();
        DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
        'product_code'=>$getSKU->sku,'product_color'=>$product_color,'price'=>$data['price'],
        'size'=>$product_size,'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
        

        return redirect('cart')->with('flash_message_success','Product has been added into Cart!!!');
    }
    public function cart(){
        if(Auth::check()){
        $user_email = Auth::user()->email;
        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
        foreach($userCart as $key => $product){
        //echo $product->product_id;
        $productDetails = Product::where('id',$product->product_id)->first();
        $userCart[$key]->image = $productDetails->image;
        }
        //echo"<pre>"; print_r($userCart);die;
        return view('products.cart')->with(compact('userCart'));
    }
    public function deleteCartProduct($id = NULL){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_error','Product has been deleted from Cart');
    
    }
    public function updateCartQuantity($id=null,$quantity=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getCartSetails = DB::table('cart')->where('id',$id)->first();
        $getAttributeStock = ProductsAttribute::where('sku',$getCartSetails->product_code)->first();
        $updated_quantity = $getCartSetails->quantity+$quantity;
        if($getAttributeStock->stock >= $updated_quantity){
        DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
        return redirect('cart')->with('flash_message_success','Product Quantity has been Updated Successfully!!');
        }else{
        return redirect('cart')->with('flash_message_error','Required Product Quantity is not Available');  
        }
    }
    public function ApplyCoupon(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
       // echo"<pre>";print_r($data);die;
        $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error','Coupon does not Exists!');
        }else{
           //perform other actions like active,inactive or expiry date

           //Get Coupon Details
            $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();
           //if coupon is valid
            if($couponDetails->status== 0){
                return redirect()->back()->with('flash_message_error','This Coupon is not active!');
            }
           //if coupon is expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
        if($expiry_date < $current_date){
            return redirect()->back()->with('flash_message_error','This Coupon is Expired!');
        }
           //Coupon is valid for Discount
           //Get Cart total amount
            $session_id =Session::get('session_id');
            if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
            }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
            }
            $total_amount = 0;
            foreach($userCart as $item){
            $total_amount = $total_amount + ($item->price * $item->quantity);
        }
           //Check if amount type is fixed or percentage
            if($couponDetails->amount_type=="Fixed"){
                $couponAmount = $couponDetails->amount;
            }else{
               $couponAmount = $total_amount * ($couponDetails->amount/100);
            }
            //Add coupon Code & Amount in session
            Session::put('CouponAmount',$couponAmount);
            Session::put('CouponCode',$data['coupon_code']);
            return redirect()->back()->with('flash_message_success','Coupon Code is successfully
            applied.You are availing discount!');
        }
    }
    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();
        //Check if shipping address exists
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        //Update Cart Table with user id or email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        
        if($request->isMethod('post')){
        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        //Return to checkout page if any field is empty
        if(empty($data['billing_name']) ||empty($data['billing_address'])
        ||empty($data['billing_city']) ||empty($data['billing_state'])
        ||empty($data['billing_country']) ||empty($data['billing_pincode'])
        ||empty($data['billing_mobile']) ||empty($data['shipping_name'])
        ||empty($data['shipping_address']) ||empty($data['shipping_city'])
        ||empty($data['shipping_state']) ||empty($data['shipping_country'])
        ||empty($data['shipping_pincode']) ||empty($data['shipping_mobile'])){
            return redirect()->back()->with('flash_message_error','Please Fill all 
            Fields to Continue!!');
        }
        //Update User Details
        User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],
        'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],
        'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);

        if($shippingCount>0){
          //Update Shipping Address
            DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],
            'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],
            'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
        }else{
          //New Shipping Address
            $shipping = new DeliveryAddress;
            $shipping->user_id = $user_id;
            $shipping->user_email = $user_email;
            $shipping->name = $data['shipping_name'];
            $shipping->address = $data['shipping_address'];
            $shipping->city = $data['shipping_city'];
            $shipping->state = $data['shipping_state'];
            $shipping->pincode = $data['shipping_pincode'];
            $shipping->country = $data['shipping_country'];
            $shipping->mobile = $data['shipping_mobile'];
            $shipping->save();
        }
        return redirect()->action('ProductsController@orderReview');
        }
        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));

    }
    public function orderReview(Request $request){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails =json_decode(json_encode($shippingDetails));

        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach($userCart as $key =>$product){
        //echo $product->product_id;
        $productDetails = Product::where('id',$product->product_id)->first();
        $userCart[$key]->image = $productDetails->image;
        }
        //echo "<pre>";print_r($userCart);die;
        return view('products.order_review')->with(compact('userDetails','shippingDetails','userCart'));
    }
    public function placeOrder(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            //Prevent out of stock products from ordering
            $userCart = DB::table('cart')->where('user_email',$user_email)->get();
            foreach($userCart as $cart){
                $product_stock = Product::getProductStock($cart->product_id,$cart->size);
                if($product_stock==0){
                    return redirect('/cart')->with('flash_message_error','Produce is Sold Out! Please Choose another product.');
                }
                // echo "Original Stock: ".$product_stock;
                // echo "Demanded Stock: ".$cart->quantity;
                if($cart->quantity>$product_stock){
                    return redirect('/cart')->with('flash_message_error','Reduce Produce Stock and try again.');    
                }
            }


            //Get Shipping Detail for User
            $shippingDetails = DeliveryAddress::where(['user_email'=>$user_email])->first();
            //echo "<pre>";print_r($data);die;
            if(empty(Session::get('CouponCode'))){
                $coupon_code = '';
            }else{
                $coupon_code =Session::get('CouponCode');
            }
            if(empty(Session::get('CouponAmount'))){
                $coupon_amount = '';
            }else{
                $coupon_amount =Session::get('CouponAmount');
            }
            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();

                //Reduce Stock Script Starts
                $getProductStock = ProductsAttribute::where('sku',$pro->product_code)->first();
                // echo "Original Stock: ".$getProductStock->stock;
                // echo "Stock to reduce: ".$pro->quantity;
                $newStock = $getProductStock->stock - $pro->quantity;
                if($newStock<0){
                    $newStock = 0;
                }
                ProductsAttribute::where('sku',$pro->product_code)->update(['stock' => $newStock]);
                //Reduce Stock Script Ends

            }
                            
            Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);
            if($data['payment_method']=="COD"){
                $productdetails = Order::with('orders')->where('id',$order_id)->first();
				$productdetails = json_decode(json_encode($productdetails),true);
				// echo "<pre>"; print_r($productdetails); die;
				
				$userDetails = User::where('id',$user_id)->first();
				$userDetails = json_decode(json_encode($userDetails),true);
                // echo "<pre>"; print_r($userDetails); die;
                
                /* Code for Order Email Start */
				$email = $user_email;
				$messageData = [
					'email'=>$email,
					'name'=>$shippingDetails->name,
					'order_id'=>$order_id,
					'productdetails'=>$productdetails,
					'userDetails'=>$userDetails
				];
				Mail::send('email.order',$messageData,function($message) use($email){
					$message->to($email)->subject('Order Palced - Hypermart Website');
				});
                /* Code for order Email Ends */
                
                //COD - Redirect user to thanks page after saving order
                return redirect('/thanks');
            }else{
                //Paypal - Redirect user to Paypal page after saving order
                return redirect('/paypal');  
            }
            
        }
    }
    public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }
    public function userOrders(){
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        //$orders = json_decode(json_encode($orders));
        //echo "<pre>";print_r($orders);

        return view('orders.user_orders')->with(compact('orders'));
    }
    public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        //echo "<pre>";print_r($orderDetails);die;
        return view('orders.user_order_details')->with(compact('orderDetails','userCart'));
    }
    public function paypal(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
        
    }
    public function viewOrders(){
        $orders = Order::with('orders')->orderBy('id','DESC')->get();
        $orders = json_decode(json_encode($orders));
        //echo "<pre>";print_r($orders);die;
        return view('admin.orders.view_orders')->with(compact('orders'));
    }
    public function viewOrderDetails($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        //echo "<pre>"; print_r($orderDetails);die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        $userDetails = json_decode(json_encode($userDetails));
        //echo "<pre>"; print_r($userDetails);die;
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

    public function viewOrderInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        //echo "<pre>"; print_r($orderDetails);die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        $userDetails = json_decode(json_encode($userDetails));
        //echo "<pre>"; print_r($userDetails);die;
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
        }
        Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
        return redirect()->back()->with('flash_message_success','Order Status has been Updated Successfully!');
    }
}