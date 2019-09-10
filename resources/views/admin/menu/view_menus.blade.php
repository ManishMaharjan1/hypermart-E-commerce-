@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Menus</a> <a href="#" class="current">View Menus</a> </div>
        <h1>Menus</h1>
        @include('layouts.msg')
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Menus</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ url('/admin/del-menu')}}" method="post"> {{ csrf_field() }}
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Menu Title</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($menus as $menu)
                <tr class="gradeX">
                    <td><input type="checkbox" name="delId[]" value="{{ $menu->id }}"></td>
                    <td>{{ $menu->id }}</td>
                    <td>{{ $menu->name }}</td>
                    <td class="center">
                    <div class="fr">
                    <a href="{{url('/admin/edit-menu/'.$menu->id)}}" class="btn btn-inverse btn-mini">Edit</a>
                    <a  rel="{{$menu->id}}" rel1="delete-menu"
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