@extends('layouts.admin_template')
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src={{ asset("/assets/admin/assets/js/moment.min.js")}}></script>
        <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/daterangepicker.css")}}">
        <script src={{ asset("/assets/admin/assets/js/daterangepicker.min.js")}}></script>    
@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Product</strong></h2>     
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
                <strong>Filter</strong> Products
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'category-product/product' , 'method'=>'GET' )) }}
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
                            <div class="col col-md-2"><label for="gender_allocation" class=" form-control-label">Gender Allocation</label></div>
                            <div class="col-12 col-md-9">
                              <select class="form-control" name="gender_allocation">
                              <option value="">--- NONE ---</option>
                                @foreach($gender_allocations as $ga)
                                <option value="{{ $ga->id }}" {{ $request->gender_allocation == $ga->id? 'selected' : '' }}>{{ $ga->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>                                                                    
                      </div>
                      <div class="col-lg-6">
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="_period" class=" form-control-label">Period</label></div>
                            <div class="col-11 col-md-8"><input id="" name="_period" class="form-control dateRangePicker" value="{{ $request->_period ? $request->_period : '' }}"></div>
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
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('category-product/product/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Products
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Slug</th>                      
                      <th>Category</th>
                      <th>Gender Allocation</th>
                      <th>Price</th>
                      <th width="10%">View & Buy</th>
                      <th width="5%">Status</th>
                      <th width="15%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('category-product/product/load-data?genAlloc='. $request->gender_allocation.'&name='. $request->_name.'&categoryParent='. $request->category_parent.'&categoryChild='. $request->category_child.'&status='. $request->status) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          {
                              mRender: function (data, type, row) {
                              if (row._image_url != null && row._image_real_name != null) {
                                    return '<img src="{{ url("/") }}' +  row._image_url + '" />'
                                } else {
                                    return '-'
                                }
                              }                            
                          },
                          { data: '_name', name: '_name' },
                          { data: '_slug', name: '_slug' },
                          { data: 'category_name', name: 'category_name' },
                          { data: 'gender_name', name: 'gender_name' },
                          { data: '_price', name: '_price' },
                          {
                              mRender: function (data, type, row) {
                                return '<center>View : '+ row._count_view +' <br> Buy : '+ row._count_buy +'</center>'
                              }                            
                          },
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
                                '<a href=product/' + row.id + '/edit class="btn btn-primary"role="button">Manage<a> ' +
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
    var $ = jQuery;
    $(document).ready(function() {
        $('.dateRangePicker').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
              format: 'YYYY-MM-DD HH:mm:ss',
              cancelLabel: 'Clear'
            }
        });
    });
    $('.dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
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
          url: 'product/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection