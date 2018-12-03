@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    
        <script type="text/javascript" src="{{ asset("/assets/admin/assets/js/lib/moment/moment.js")}}"></script>
        <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/daterangepicker.css")}}">
        <script src={{ asset("/assets/admin/assets/js/daterangepicker.min.js")}}></script>
@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Website Management Ads/Inventory Banner</strong></h2>     
  </div>
</div>
<hr>
@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
@endif
<div class="row">
    <div class="col-lg-7">



        <div class="card">
            <div class="card-header">
                <strong>Filter</strong> Ads/Inventory Banner
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'web-management/adsInventory' , 'method'=>'GET' )) }}
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="banner_type_id" class=" form-control-label">Banner Type</label></div>
                        <div class="col-12 col-md-9">
                          <select class="form-control" name="banner_type_id">
                                <option value="">--- Banner Type ---</option>
                            @foreach($banner_types as $type)
                                <option value="{{ $type->id }}" {{ $request->banner_type_id == $type->id? 'selected' : '' }}>{{ $type->_name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="_title" class=" form-control-label">Title</label></div>
                        <div class="col-12 col-md-9"><input id="" name="_title" class="form-control" value="{{ $request->_title ? $request->_title : '' }}"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="_href_url" class=" form-control-label">Href URL</label></div>
                        <div class="col-12 col-md-9"><input id="" name="_href_url" class="form-control" value="{{ $request->_href_url ? $request->_href_url : '' }}"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="_period" class=" form-control-label">Period</label></div>
                        <div class="col-11 col-md-8"><input id="" name="_period" class="form-control dateRangePicker" value="{{ $request->_period ? $request->_period : '' }}"></div>   
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="status" class=" form-control-label">Active</label></div>
                        <div class="col-12 col-md-9">
                          <select class="form-control" name="status">
                            <option value="" {{ !isset($request->status) ? 'selected' : '' }}>Please Select</option>
                            <option value="true" {{ $request->status == 'true' ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ $request->status == 'false' ? 'selected' : '' }}>No</option>
                          </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary"><strong>Submit</strong></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>


        
    </div>
    <div align="right" class="col-sm-12">
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('web-management/adsInventory/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Ads/Inventory Banner
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>HREF URL</th>
                      <th width="10%">Status</th>
                      <th width="30%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('web-management/adsInventory/load-data?banner_type_id='. $request->banner_type_id . '&_title='. $request->_title. '&_href_url='. $request->_href_url . '&status='. $request->status . '&_period='. $request->_period) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: '_image_url', name: '_image_url',
                            render: function( data, type, full, meta ) {
                                return "<img src=\"{{ url('/') }}" + data + "\"/>";
                            }
                          },
                          { data: '_title', name: '_title' },
                          { data: '_href_url', name: '_href_url' },
                          { data: '_active', name: '_active' },
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href=adsInventory/' + row.id + '/edit class="btn btn-primary"role="button">View & Edit<a> ' +
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
    var $ = jQuery;
    $(document).ready(function() {
        $('.dateRangePicker').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
              format: 'YYYY-MM-DD',
              cancelLabel: 'Clear'
            }
        });
    });
    $('.dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
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
          url: 'adsInventory/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection