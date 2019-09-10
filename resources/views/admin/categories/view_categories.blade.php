@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Categories</a> <a href="#" class="current">View Categories</a> </div>
        <h1>Categories</h1>
        @include('layouts.msg')
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Categories</h5>
            </div>
            <div class="widget-content nopadding">
            <form action="{{ url('/admin/del-category') }}" method="post"> {{ csrf_field() }}
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Level</th>
                    <th>Category URL</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                  <tr class="gradeX">
                    <td><input type="checkbox" name="delId[]" value="{{ $category->id }}"></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->Name }}</td>
                    <td>{{ $category->Parent_id }}</td>
                    <td>{{ $category->url }}</td>
                  <td class="center"><div class="fr"><a href="{{url('/admin/edit-category/'.$category->id)}}" class="btn btn-primary btn-mini">Edit</a>
                    <a  rel="{{$category->id}}" rel1="delete-category"
                        href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></div></td>              
                </tr>
                @endforeach
                </tbody>
              </table>
              <button type="submit" class="btn btn-danger btn-mini">Delete Selected</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection