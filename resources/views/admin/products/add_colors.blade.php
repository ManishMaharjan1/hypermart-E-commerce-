@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Products Colors</a> <a href="#" class="current">Add Products Colors</a> </div>
      <h1>Products Colors</h1>
      @include('layouts.msg')
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Products Colors</h5>
            </div>
            <div class="widget-content nopadding">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-colors/'.$productDetails->id) }}"
                name="add_attribute" id="add_attribute"> {{csrf_field()}}
                <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                  <div class="control-group">
                    <label class="control-label">Product Name</label>
                    <label class="control-label"><strong>{{$productDetails->product_name}}</strong></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Product Code</label>
                    <label class="control-label"><strong>{{$productDetails->product_code}}</strong></label>
                  </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="field_wrapper">
                        <div>
                        <input type="text" name="product_color[]" id="product_color" placeholder="Color" style="width:120px;" required/>
                        <a href="javascript:void(0);" class="add_field" title="Add field">Add</a>
                            </div>
                        </div>
                    </div>
                  <div class="form-actions">
                    <input type="submit" value="Add Colors" class="btn btn-success">
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
        <h5>View Colors</h5>
        </div>
        <div class="widget-content nopadding">
        <form enctype="multipart/form-data" action="{{ url('/admin/edit-colors/'.$productDetails->id) }}" method="post"> {{ csrf_field() }}
        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th>Color ID</th>
              <th>Color Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($productDetails['colors'] as $color)
              <tr class="gradeX">
              <td><input type="hidden" name="idAttr[]" value="{{$color->id }}"> {{$color->id }}</td>
              <td><input type="text" name="product_color[]" value="{{$color->product_color}}"></td>
            <td class="center"><div class="fr">
              <input type="submit" value="Update" class="btn btn-primary btn-mini">
            <a  rel="{{$color->id}}" rel1="delete-color"
              href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></div></td>              
            </tr> 
          @endforeach
          </tbody>
        </table>
          </form>
        </div>
        </div>
        </div>
        </div>
    </div>
  </div>
@endsection