@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Cmspages</a> <a href="#" class="current">Add Cmspage</a> </div>
      <h1>Cmspages</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Cmspage</h5>
            </div>
            <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('/admin/add-cmspage') }}"
             name="add_cmspage" id="add_cmspage" novalidate="novalidate"> {{csrf_field()}}
                <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                        <input type="text" name="title" id="title">
                    </div>
                </div>

                <div class="control-group">
                  <label class="control-label">URL</label>
                  <div class="controls">
                    <input type="text" name="url" id="url">
                  </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                      <textarea name="description" id="description"> </textarea>
                    </div>
                  </div>

                <div class="control-group">
                    <label class="control-label">Publication Status</label>
                    <div class="controls">
                        <input type="checkbox" name="publication_status" id="publication_status" value="1">
                    </div>
                </div>

                <div class="form-actions">
                  <input type="submit" value="Add CmsPage" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection