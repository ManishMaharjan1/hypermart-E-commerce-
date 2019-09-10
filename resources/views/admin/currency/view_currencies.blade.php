@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url ('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Currencies</a> <a href="#" class="current">View Currencies</a> </div>
        <h1>Currencies</h1>
        @include('layouts.msg')
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Currencies</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Currencies ID</th>
                    <th>Currencies Code</th>
                    <th>Exchange Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($currencies as $currency)
                <tr class="gradeX">
                    <td>{{ $currency->id }}</td>
                    <td>{{ $currency->currency_code }}</td>
                    <td>{{ $currency->exchange_rate }}</td>
                    <td class="center">
                        @if($currency->publication_status == 1)
                            <span class="label label-success">Active</span>
                        @else
                            <span class="label label-warning">Inactive</span>
                        @endif
					        </td>
                    <td class="center">
                    <div class="fr">
                    @if($currency->publication_status == 1)
                    <a class="btn btn-warning btn-mini" href="{{URL::to('/admin/inactive_currency/' . $currency->id)}}">
                      Inactive  
                    </a>
					@else
                    <a class="btn btn-success btn-mini" href="{{URL::to('/admin/active_currency/' . $currency->id)}}">
                      Active 
                    </a>
                    @endif
                    <a href="{{url('/admin/edit-currency/'.$currency->id)}}" class="btn btn-inverse btn-mini">Edit</a>
                    <a  rel="{{$currency->id}}" rel1="delete-cmspage"
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