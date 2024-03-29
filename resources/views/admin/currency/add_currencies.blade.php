@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Currencies</a> <a href="#" class="current">Add Currencies</a> </div>
      <h1>Currencies</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Currencies</h5>
            </div>
            <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('/admin/add-currency') }}"
             name="add_currency" id="add_currency" novalidate="novalidate"> {{csrf_field()}}
                <div class="control-group">
                    <label class="control-label">Currency_code</label>
                    <div class="controls">
                        <input type="text" name="currency_code" id="currency_code">
                    </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Exchange_rate</label>
                  <div class="controls">
                    <input type="text" name="exchange_rate" id="exchange_rate">
                  </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Publication Status</label>
                    <div class="controls">
                        <input type="checkbox" name="publication_status" id="publication_status" value="1">
                    </div>
                </div>

                <div class="form-actions">
                  <input type="submit" value="Add Currency" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection