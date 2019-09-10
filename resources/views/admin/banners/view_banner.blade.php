@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Banners</a> <a href="#" class="current">View Banners</a> </div>
        <h1>Banners</h1>
        @include('layouts.msg')
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Banners</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Banner ID</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($banners as $banner)
                    <tr class="gradeX">
                    <td>{{ $banner->id }}</td>
                    <td>
                        @if(!empty($banner->image))
                            <img src="{{asset('/images/backend_img/banners/'.$banner->image)}}"
                                style="width:100px;">
                    </td>
                        @endif
                    <td class="center">
									@if($banner->publication_status == 1)
										<span class="label label-success">Active</span>
									@else
										<span class="label label-danger">Inactive</span>
									@endif
								    </td>
                    <td class="center">
                    <div class="fr">
                    @if($banner->publication_status == 1)
						        <a class="btn btn-info btn-mini" href="{{URL::to('/admin/inactive_banner/' . $banner->id)}}">
							        Inactive  
						        </a>
					          @else
						        <a class="btn btn-success btn-mini" href="{{URL::to('/admin/active_banner/' . $banner->id)}}">
							        Active 
						        </a>
					          @endif
                    <a  rel="{{$banner->id}}" rel1="delete-banner"
                        href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></div></td>              
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection