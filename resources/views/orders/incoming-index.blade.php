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
    <h2><strong>Manage Incoming Order</strong></h2>     
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
                <strong>Filter</strong> Incoming Order
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'order-management/incoming-order' , 'method'=>'GET' )) }}
                  <div class="row form-group">
                      <div class="col col-md-3"><label for="keyword" class=" form-control-label">Keyword</label></div>
                      <div class="col-12 col-md-9"><input id="" name="keyword" class="form-control" value="{{ $request->keyword ? $request->keyword : '' }}" placeholder="order id/receiver email/ name phone"></div>
                  </div>
                  <div class="row form-group">
                      <div class="col col-md-3"><label for="_period" class=" form-control-label">Period</label></div>
                      <div class="col-11 col-md-8"><input id="" name="_period" class="form-control dateRangePicker" value="{{ $request->_period ? $request->_period : '' }}" autocomplete="false"></div>
                  </div>                  
                  <div class="row form-group">
                      <div class="col col-md-3"><label for="paymentMethod" class=" form-control-label">Payment Method</label></div>
                      <div class="col-12 col-md-9">
                        <select class="form-control" name="paymentMethod">
                          <option value="" {{ !isset($request->paymentMethod) ? 'selected' : '' }}>All</option>
                          @foreach($payment_methods as $pm)
                          <option value="{{ $pm->id }}" {{ $request->paymentMethod == $pm->id? 'selected' : '' }}>{{ $pm->_name }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>

                  <div>
                      <button type="submit" class="btn btn-primary"><strong>Search</strong></button>
                  </div>
              {!! Form::close() !!}
            </div>            
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Incoming Order
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Order ID</th>
                      <th>Email</th>
                      <th>Receiver Name</th>                      
                      <th>Receiver Phone</th>
                      <th>Address</th>
                      <th width="5%">Status</th>
                      <th>Grand Total</th>
                      <th>Order Date</th>
                      <th width="15%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('order-management/incoming-order/load-data?keywordSearch='. $request->keyword.'&period='. $request->_period.'&paymentMethod='. $request->paymentMethod) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: 'id', defaultContent: '' },
                          { data: '_email', name: '_email' },
                          { data: '_receiver_name', name: '_receiver_name' },
                          { data: '_receiver_phone', name: '_receiver_phone' },
                          { data: '_address', name: '_address' },
                          { data: '_name', name: '_name' },
                          { data: '_grand_total', name: '_grand_total' },
                          { data: 'created_at', name: 'created_at' },                          
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href=order/' + row.id + ' class="btn btn-primary"role="button">Detail<a> ' +
                                '<a href=order/item/' + row.id + ' class="btn btn-success"role="button">View Item<a> ' +
                                '</br><a href="javascript:checkConfirmOrder('+ row.id +');" class="btn btn-success"role="button">Confirm Order<a> ' +
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

    function checkConfirmOrder(id) {
      if (confirm('Are you sure want to confirm order?')) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
          });
          $.ajax({
            type: "POST",
            url: 'order/confirm-order/' + id,
            success: function(result) {
               location.reload();
            }
          });
        }
    }
</script>

@endsection