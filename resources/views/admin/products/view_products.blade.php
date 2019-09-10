@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
<div id="content-header">
<div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
<a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
<h1>Products</h1>
@include('layouts.msg')
</div>
<div class="container-fluid">
<hr>
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
<h5>View Products</h5>
</div>
<div class="widget-content nopadding">
<form action="{{ url('/admin/del-product') }}" method="post"> {{ csrf_field() }}
<table class="table table-bordered data-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Product ID</th>
      <th>Category ID</th>
      <th>Category Name</th>
      <th>Product Name</th>
      <th>Product Code</th>
      <th>Price</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($products as $product)
      <tr class="gradeX">
      <td><input type="checkbox" name="delId[]" value="{{ $product->id }}"></td>
      <td>{{ $product->id }}</td>
      <td>{{ $product->category_id }}</td>
      <td>{{ $product->category_name }}</td>
      <td>{{ $product->product_name }}</td>
      <td>{{ $product->product_code }}</td>
      <td>{{ $product->price }}</td>
      <td>
          @if(!empty($product->image))
      <img src="{{asset('/images/backend_img/products/small/'.$product->image)}}"
      style="width:60px;">
      </td>
          @endif
    <td class="center">
      <div class="btn-group"><a href="#myModal{{ $product->id }}" data-toggle="modal" 
      class="btn btn-success btn-mini" title="View Products">View</a>
      <a href="{{url('/admin/edit-product/'.$product->id)}}" class="btn btn-primary btn-mini" title="Edit Products">Edit</a>
      <a href="{{url('/admin/add-attributes/'.$product->id)}}" class="btn btn-info btn-mini" title="Add Attributes">Add</a>
      <a href="{{url('/admin/add-images/'.$product->id)}}" class="btn btn-warning btn-mini" title="Add Images">Add Img</a>
      <a href="{{url('/admin/add-colors/'.$product->id)}}" class="btn btn-primary btn-mini" title="Add Colors">Add Color</a>
    <a  rel="{{$product->id}}" rel1="delete-product"
      href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete Products">Delete
    </a>
    </div>
    </td>              
  </tr> 
          <div id="myModal{{ $product->id }}" class="modal hide">
            <div class="modal-header">
              <button data-dismiss="modal" class="close" type="button">×</button>
              <h3>{{ $product->product_name }} Full Details</h3>
            </div>
            <div class="modal-body">
              <p>Product ID : {{ $product->id }}</p>
              <p>Category ID : {{ $product->category_id }}</p>
              <p>Product Name : {{ $product->product_name }}</p>
              <p>Product Code : {{ $product->product_code }}</p>
              @if(!empty($product->sleeve))
              <p>Sleeve : {{ $product->sleeve }}</p>
              @endif
              <p>Price : ${{ $product->price }}</p>
              <p>Product Description : {{ $product->description }}</p>
              <p>Material & Care : {{$product->care}}</p>
            </div>
          </div>
  @endforeach
  </tbody>
</table>
<button type="submit" class="btn btn-danger btn-mini">Deleted Selected</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
