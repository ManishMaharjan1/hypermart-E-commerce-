<?php 
// Get the current URL without the query string...
 $url = url()->current();
?>
<!--sidebar-menu-->
<div id="sidebar"><a href="{{url('/admin/dashboard')}}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
      <li <?php if(preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?>>
        <a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i><span>Dashboard</span></a> </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/category/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-category')}}">Add Category</a></li>
          <li <?php if(preg_match("/view-categories/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-categories')}}">View Categories</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Menu</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/menu/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-menu/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-menu')}}">Add Menu</a></li>
          <li <?php if(preg_match("/view-menus/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-menus')}}">View Menu</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/product/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-product/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-product')}}">Add Products</a></li>
          <li <?php if(preg_match("/view-products/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-products')}}">View Products</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/coupon/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-coupon')}}">Add Coupon</a></li>
          <li <?php if(preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-coupons')}}">View Coupons</a></li>
        </ul>
      </li>

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> <span class="label label-important">1</span></a>
        <ul <?php if(preg_match("/orders/i", $url)){ ?> style="display:block;" <?php } ?>>
          <li <?php if(preg_match("/view-orders/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-orders')}}">View Orders</a></li>
        </ul>
      </li>

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banners</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/banner/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-banner')}}">Add Banner</a></li>
          <li <?php if(preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-banners')}}">View Banners</a></li>
        </ul>
      </li>

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
        <ul <?php if(preg_match("/users/i", $url)){ ?> style="display:block;" <?php } ?>>
          <li <?php if(preg_match("/view-users/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-users')}}">View Users</a></li>
        </ul>
      </li>
      
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>CmsPages</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/cmspage/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-cmspage/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-cmspage')}}">Add Cmspage</a></li>
          <li <?php if(preg_match("/view-cmspages/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-cmspages')}}">View Cmspages</a></li>
        </ul>
      </li>

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Currencies</span> <span class="label label-important">2</span></a>
        <ul <?php if(preg_match("/currency/i", $url)){ ?> style="display:block;" <?php } ?>>
        <li <?php if(preg_match("/add-currency/i", $url)){ ?> class="active" <?php } ?>>
          <a href="{{url ('/admin/add-currency')}}">Add Currencies</a></li>
          <li <?php if(preg_match("/view-currencies/i", $url)){ ?> class="active" <?php } ?>>
            <a href="{{url ('/admin/view-currencies')}}">View Currencies</a></li>
        </ul>
      </li>

    </ul>
  </div>
  <!--sidebar-menu-->
  