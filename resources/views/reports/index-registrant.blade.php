@extends('layouts.admin_template')
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link  href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

        <script src={{ asset("/assets/admin/assets/js/moment.min.js")}}></script>
        <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/daterangepicker.css")}}">
        <script src={{ asset("/assets/admin/assets/js/daterangepicker.min.js")}}></script>   
@section('content')
<div id="printable">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<div class="row">
	  <div class="col-sm-12">
	    <h2><strong>Report - Registrant</strong></h2>     
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
	                <strong>Filter</strong> Report - Registrant
	            </div>
	            <div class="card-body card-block">
	                {{ Form::open(array('url'=>'report/registrant' , 'method'=>'GET' )) }}
	                  <div class="row form-group">
	                      <div class="col col-md-3"><label for="_period" class=" form-control-label">Period</label></div>
	                      <div class="col-11 col-md-8"><input id="" name="_period" class="form-control dateRangePicker" value="{{ $request->_period ? $request->_period : '' }}" autocomplete="false"></div>
	                  </div>
	                  <div class="row form-group">
	                      <div class="col col-md-3"><label for="verified" class=" form-control-label">Verified</label></div>
	                      <div class="col-12 col-md-9">
	                        <select class="form-control" name="verified">
	                          	<option value="all" {{ isset($request->verified) && $request->verified == 'all' ? 'selected' : '' }}>All</option>
	                          	<option value="email" {{ isset($request->verified) && $request->verified == 'email' ? 'selected' : '' }}>Email</option>
		                        <option value="phone" {{ isset($request->verified) && $request->verified == "phone" ? 'selected' : '' }}>Phone</option>
		                        <option value="notverified" {{ isset($request->verified) && $request->verified == 'notverified' ? 'selected' : '' }}>Not Verified</option>
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
	    <div class="col-lg-5">
	        <div class="card">
	            <div class="card-header">
	                <h4><strong>Detail</strong></h4>
	            </div>
	            <div class="card-body card-block">
	                  <div class="row form-group">
	                  	<h4><strong>Total User : {{ $total_user }}</strong></h4>
	                  </div>
	                  <div class="row form-group">
	                  	<h4><strong>Total Verified Email : {{ $total_user_email_verified }}</strong></h4>
	                  </div>
	                  <div class="row form-group">
	                  	<h4><strong>Total Verified Phone : {{ $total_user_phone_verified }}</strong></h4>
	                  </div>
	                  <div class="row form-group">
	                  	<h4><strong>Total Not Verified : {{ $total_user_not_verified }}</strong></h4>
	                  </div>                  
	            </div>            
	        </div>
	    </div>
	</div>
	<div class="row">    
	    <div align="right" class="col-sm-12">
	        <button type="button" class="btn btn-success" onclick="location.href=''"><strong>Export</strong></button>
	        <!-- <button type="button" class="btn btn-primary" onclick="printDiv('printable')"><strong>Print</strong></button> -->
	    </div>
	    <div class="col-sm-12">
	        <div class="card">  
	            <div class="card-header">
	                <strong class="card-title">List </strong>Registrant
	            </div>
	            <div class="card-body">
	              <table class="table table-bordered" id="table" class="col-sm-12">
	                 <thead>
	                    <tr>
	                      <th width="5%">ID</th>
	                      <th width="10%">Email</th>
	                      <th width="10%">Email Verified</th>
	                      <th width="15%">Phone</th>                      
	                      <th width="15%">Phone Verified</th>
	                      <th width="5%">First Name</th>
	                      <th width="5%">Last Name</th>
	                      <th width="5%">Gender</th>
	                      <th width="15%">Birthdate</th>
	                      <th width="15%">Created Date</th>
	                    </tr>
	                 </thead>
	              </table>
	          <script>
	           $(function() {
	                var url_clean = "{{ url('report/registrant/load-data?period='. $request->_period.'&verified='. $request->verified) }}"
	                var fix_url = url_clean.replace(/&amp;/g, '&');
	                 $('#table').DataTable({
	                 dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
             {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                titleAttr : 'PDF'
             }
        ],
	                 processing: true,
	                 serverSide: true,
	                 searching: false,
	                 ajax: fix_url,
	                 columns: [
	                          { data: 'id', defaultContent: '' },
	                          { data: '_email', name: '_email' },
	                          { data: '_verified_email_at', name: '_verified_email_at' },
	                          { data: '_phone', name: '_phone' },
							  { data: '_verified_phone_at', name: '_verified_phone_at' },
	                          { data: '_first_name', name: '_first_name' },
	                          { data: '_last_name', name: '_last_name' },
	                          { data: 'gender', name: 'gender' },
	                          { data: '_dob', name: '_dob' },
	                          { data: 'created_at', name: 'created_at' }
	                       ]
	              });
	           });
	          </script>
	          </div>        
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

	function printDiv(sectionName) {
	    //var printContents = document.getElementById(sectionName).innerHTML;
//	    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/style.css")}}">
	    var prtContent = document.getElementById(sectionName);
        var WinPrint = window.open();

        WinPrint.document.write(prtContent.innerHTML);       
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
	}
</script>
@endsection