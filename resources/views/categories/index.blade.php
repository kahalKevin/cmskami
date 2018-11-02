@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Category</strong></h2>     
  </div>
</div>
<hr>
@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong> Club
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'category-product/category' , 'method'=>'GET' )) }}
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="row form-group">
                            <div class="col col-md-2"><label for="category_parent" class=" form-control-label">Category</label></div>
                            <div class="col-12 col-md-9">
                              <select class="form-control" name="category_parent">
                              <option value="">--- NONE ---</option>
                                @foreach($category_parents as $cp)
                                <option value="{{ $cp->id }}" {{ $request->category_parent == $cp->id? 'selected' : '' }}>{{ $cp->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-2"><label for="category_child" class=" form-control-label"></label></div>
                            <div class="col-12 col-md-9">
                              <select class="form-control" name="category_child">
                                <option value="">--- Select ---</option>
                                @if(isset($category_childs))
                                @foreach($category_childs as $cc)
                                  <option value="{{ $cc->id }}" {{ $request->category_child == $cc->id? 'selected' : '' }}>{{ $cc->_name }}</option>
                                @endforeach
                                @endif
                              </select>
                            </div>
                        </div>                                            
                      </div>
                      <div class="col-lg-6">
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="gender_allocation" class=" form-control-label">Gender Allocation</label></div>
                            <div class="col-12 col-md-9">
                              <select class="form-control" name="gender_allocation">
                              <option value="">--- NONE ---</option>
                                @foreach($gender_allocations as $ga)
                                <option value="{{ $ga->id }}" {{ $request->gender_allocation == $ga->id? 'selected' : '' }}>{{ $ga->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>                    
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="_name" class=" form-control-label">Name</label></div>
                            <div class="col-12 col-md-9"><input id="" name="_name" class="form-control" value="{{ $request->_name ? $request->_name : '' }}"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="status" class=" form-control-label">Active?</label></div>
                            <div class="col-12 col-md-9">
                              <select class="form-control" name="status">
                                <option value="" {{ !isset($request->status) ? 'selected' : '' }}>Please Select</option>
                                <option value="true" {{ $request->status == 'true' ? 'selected' : '' }}>Yes</option>
                                <option value="false" {{ $request->status == 'false' ? 'selected' : '' }}>No</option>
                              </select>
                            </div>
                        </div>                        
                      </div>                      
                    </div>
                    <div align="right">
                        <button type="submit" class="btn btn-primary"><strong>Submit</strong></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div align="right" class="col-sm-12">
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('category-product/category/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Club
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Parent Category</th>
                      <th>Gender Allocation</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th width="10%">Status</th>
                      <th width="30%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('category-product/category/load-data?genAlloc='. $request->gender_allocation.'&name='. $request->_name.'&categoryParent='. $request->category_parent.'&categoryChild='. $request->category_child.'&status='. $request->status) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: 'parent_category_name', name: 'parent_category_name' },
                          { data: 'gender_name', name: 'gender_name' },
                          { data: 'category_name', name: 'category_name' },
                          { data: '_slug', name: '_slug' },                          
                          {
                              mRender: function (data, type, row) {
                              if (row._active == '1') {
                                    return '<i class="fa fa-check-square"></i> Active'
                                } else {
                                    return '<i class="fa fa-square-o"></i> Not active'
                                }
                              }                            
                          },
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href=category/' + row.id + '/edit class="btn btn-primary"role="button">View & Edit<a> ' +
                                '<a href="javascript:checkDelete('+ row.id +');" class="btn btn-danger"role="button">Delete<a> ' +
                                '</center>'
                            }
                          }                   
                       ]
              });
           });
          </script>
          </div>        
        </div>
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="category_parent"]').on('change', function(){
            var category_parent = $(this).val();
            if(category_parent) {
                $.ajax({
                    url: '/category-product/category/get-category-child/'+category_parent,
                    type:"GET",
                    dataType:"json",
                    beforeSend: function(){
                        $('#loader').css("visibility", "visible");
                    },

                    success:function(data) {

                        $('select[name="category_child"]').empty();
                        $('select[name="category_child"]').append('<option value="">--- Select ---</option>');
                        $.each(data, function(key, value){

                            $('select[name="category_child"]').append('<option value="'+ key +'">' + value + '</option>');

                        });
                    },
                    complete: function(){
                        $('#loader').css("visibility", "hidden");
                    }
                });
            } else {
                $('select[name="category_child"]').empty();
            }

        });
    });
</script>
<script type="text/javascript">
  function checkDelete(id) {
    if (confirm('Really Delete?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
          type: "DELETE",
          url: 'category/' + id,
          success: function(result) {
             //location.reload();
          }
        });
      }
  }
</script>
@endsection