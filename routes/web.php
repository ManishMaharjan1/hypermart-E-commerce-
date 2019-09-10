<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::match(['get','post'],'/admin', 'AdminController@login'); //submit our form for login process

Auth::routes();
//Home Page Route
Route::get('/home', 'HomeController@index')->name('home');

//Index page
Route::get('/','IndexController@index');

//Contact Us page Route
Route::get('/contact-us','IndexController@contactUs');

//Products Filter Page
Route::match(['get','post'],'/products-filter','ProductsController@filter');

//Category listing page  
Route::get('/products/{url}','ProductsController@products');

//Product Detail Page
Route::get('product/{id}','ProductsController@product');

//Cart Page Route
Route::match(['get','post'],'/cart', 'ProductsController@cart');

//Add to cart Route
Route::match(['get','post'],'/add-cart', 'ProductsController@addtocart');

//Delete Cart items Route
Route::get('cart/delete-product/{id}','ProductsController@deleteCartProduct');

//Update product quantity in cart
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');

//Get product Attribute Price
Route::get('/get-product-price','ProductsController@getProductPrice');

//Apply Coupon Code
Route::post('/cart/apply-coupon','ProductsController@ApplyCoupon');

// User Login/Register Route
Route::get('/login-register','UsersController@userLoginRegister');

Route::match(['get','post'],'forgot-password','UsersController@forgotPassword');

// User register form submit
Route::post('/user-register','UsersController@register');

//Confirm Account//
Route::get('confirm/{code}','UsersController@confirmAccount');

//Check if user already exists//
Route::match(['get','post'],'/check-email','UsersController@checkEmail');

//User Login Route
Route::post('/user-login','UsersController@login');

//User LogOut Route
Route::get('user-logout','UsersController@logout');

//All Routes after login
Route::group(['middleware' => ['frontlogin']],function(){
//User account Page
Route::match(['get','post'],'account','UsersController@account');
//check user current pwd route
Route::post('/check-user-pwd','UsersController@chkUserPassword');
//update user password
Route::post('/update-user-pwd','UsersController@updatePassword');
//checkout page
Route::match(['get','post'],'checkout','ProductsController@checkout');
//Order Review Page
Route::match(['get','post'],'order-review','ProductsController@orderReview');
//Place Order
Route::match(['get','post'],'place-order','ProductsController@placeOrder');
//COD Thanks Page
Route::get('/thanks','ProductsController@thanks');
//Stripe  Page
Route::get('/paypal','ProductsController@paypal');
//User Orders Page
Route::get('/orders','ProductsController@userOrders');
//User Ordered Products Page
Route::get('/orders/{id}','ProductsController@userOrderDetails');
});

//Check if user is already exists
Route::match(['GET','POST'],'/check-email','UsersController@checkEmail');

Route::group(['middleware' => ['adminlogin']],function(){
Route::get('/admin/dashboard', 'AdminController@dashboard');
Route::get('/admin/settings', 'AdminController@settings');
Route::get('/admin/check-pwd', 'AdminController@chkpassword');
Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

// Categories Routes (Admin)
Route::match(['get','post'],'/admin/add-category', 'CategoryController@addCategory');
Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
Route::get('/admin/view-categories', 'CategoryController@viewCategories');
Route::match(['get','post'],'/admin/del-category','CategoryController@delCategory');


//Menu Routes (Admin)
Route::match(['get','post'],'/admin/add-menu', 'MenuController@addMenu');
Route::match(['get','post'],'/admin/edit-menu/{id}','MenuController@editMenu');
Route::match(['get','post'],'/admin/delete-menu/{id}','MenuController@deleteMenu');
Route::get('/admin/view-menus', 'MenuController@viewMenus');
Route::match(['get','post'],'/admin/del-menu','MenuController@delMenu');

//Products Routes (Admin)
Route::match(['get','post'],'/admin/add-product', 'ProductsController@addProduct');
Route::match(['get','post'],'/admin/edit-product/{id}', 'ProductsController@editProduct');
Route::get('/admin/view-products','ProductsController@viewProducts');
Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteAltImage');
Route::post('/admin/del-product', 'ProductsController@delProduct');

//products attributes routes (Admin)
Route::match(['get','post'],'/admin/add-attributes/{id}', 'ProductsController@addAttributes');
Route::match(['get','post'],'/admin/edit-attributes/{id}', 'ProductsController@editAttributes');
Route::match(['get','post'],'/admin/add-images/{id}', 'ProductsController@addImages');
Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

//products color routes (Admin)
Route::match(['get','post'],'/admin/add-colors/{id}', 'ProductsController@addColors');
Route::match(['get','post'],'/admin/edit-colors/{id}', 'ProductsController@editColors');
Route::get('/admin/delete-color/{id}', 'ProductsController@deleteColor');

//Coupons Route
Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
Route::get('/admin/view-coupons', 'CouponsController@viewCoupons');
Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupon');

//Banner Route
Route::match(['get','post'],'/admin/add-banner', 'BannersController@addBanner');
Route::match(['get','post'],'/admin/delete-banner/{id}','BannersController@deleteBanner');
Route::get('/admin/view-banners', 'BannersController@viewBanners');
Route::get('/admin/inactive_banner/{id}','BannersController@inactive_banner');
Route::get('/admin/active_banner/{id}','BannersController@active_banner');

//CMS Route
Route::match(['get','post'],'/admin/add-cmspage', 'CmsController@addCmsPages');
Route::match(['get','post'],'/admin/delete-cmspage/{id}','CmsController@deleteCmsPages');
Route::get('/admin/view-cmspages', 'CmsController@viewCmsPages');
Route::get('/admin/inactive_cmspage/{id}','CmsController@inactive_cmspages');
Route::get('/admin/active_cmspage/{id}','CmsController@active_cmspages');
Route::match(['get','post'],'/admin/edit-cmspage/{id}','CmsController@editCmsPages');
//CMS for multiple delete
//Post is used becoz we r submitting the form
Route::match(['get','post'],'/admin/del-cmspage','CmsController@delCmsPages');


//Currencies Route
Route::match(['get','post'],'/admin/add-currency', 'CurrencyController@addCurrency');
Route::match(['get','post'],'/admin/delete-currency/{id}','CurrencyController@deleteCurrency');
Route::get('/admin/view-currencies', 'CurrencyController@viewCurrencies');
Route::get('/admin/inactive_currency/{id}','CurrencyController@inactive_currency');
Route::get('/admin/active_currency/{id}','CurrencyController@active_currency');
Route::match(['get','post'],'/admin/edit-currency/{id}','CurrencyController@editCurrencies');

//Admin Orders Route
Route::get('/admin/view-orders', 'ProductsController@viewOrders');

//Admin Order Detail Page
Route::get('/admin/view-order/{id}', 'ProductsController@viewOrderDetails');

//Order Invoice 
Route::get('/admin/view-order-invoice/{id}', 'ProductsController@viewOrderInvoice');

//Update Order Status
Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');

//Admin User Route//
Route::get('/admin/view-users','UsersController@viewUsers');

});

Route::get('/logout', 'AdminController@logout');

//Contact-us page
Route::match(['get','post'],'/page/contact','CmsController@contact'); 

//Display CMS page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage'); 