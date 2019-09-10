@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Cmspages</a> <a href="#" class="current">View CmsPages</a> </div>
        <h1>CmsPages</h1>
        @include('layouts.msg')
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Cmspages</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ url('/admin/del-cmspage') }}" method="post"> {{ csrf_field() }}
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>CmsPage ID</th>
                    <th>CmsPage Title</th>
                    <th>CmsPage Description</th>
                    <th>CmsPage URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($cmspages as $cmspage)
                <tr class="gradeX">
                    <td><input type="checkbox" name="delId[]" value="{{ $cmspage->id }}"></td>
                    <td>{{ $cmspage->id }}</td>
                    <td>{{ $cmspage->title }}</td>
                    <td>{{ $cmspage->description }}</td>
                    <td>{{ $cmspage->url }}</td>
                    <td class="center">
                        @if($cmspage->publication_status == 1)
                            <span class="label label-success">Active</span>
                        @else
                            <span class="label label-warning">Inactive</span>
                        @endif
					          </td>
                    <td class="center">
                    <div class="fr">
                    <a href="#myModal{{ $cmspage->id }}" data-toggle="modal" 
                    class="btn btn-info btn-mini" title="View CmsPages">View</a>
                    @if($cmspage->publication_status == 1)
                    <a class="btn btn-warning btn-mini" href="{{URL::to('/admin/inactive_cmspage/' . $cmspage->id)}}">
                      Inactive  
                    </a>
					          @else
                    <a class="btn btn-success btn-mini" href="{{URL::to('/admin/active_cmspage/' . $cmspage->id)}}">
                      Active 
                    </a>
                    @endif
                    <a href="{{url('/admin/edit-cmspage/'.$cmspage->id)}}" class="btn btn-inverse btn-mini">Edit</a>
                    <a  rel="{{$cmspage->id}}" rel1="delete-cmspage"
                        href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></div></td>              
                </tr>
                <div id="myModal{{ $cmspage->id }}" class="modal hide">
                <div class="modal-header">
                  <button data-dismiss="modal" class="close" type="button">×</button>
                  <h3>{{ $cmspage->title }} Full Details</h3>
                </div>
                <div class="modal-body">
                  <p>CmsPage ID : {{ $cmspage->id  }}</p>
                  <p>CmsPage Title : {{ $cmspage->title }}</p>
                  <p>CmsPage Description : {{ $cmspage->description }}</p>
                  <p>CmsPage URL : {{ $cmspage->url }}</p>
                </div>
                </div>
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