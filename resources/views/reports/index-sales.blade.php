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
	    <h2><strong>Report - Sales</strong></h2>     
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
	                <strong>Filter</strong> Report - Sales
	            </div>
	            <div class="card-body card-block">
	                {{ Form::open(array('url'=>'report/sales' , 'method'=>'GET' )) }}
	                  <div class="row form-group">
	                      <div class="col col-md-3"><label for="keyword" class=" form-control-label">Keyword</label></div>
	                      <div class="col-12 col-md-9"><input id="" name="keyword" class="form-control" value="{{ $request->keyword ? $request->keyword : '' }}" placeholder="order id/receiver email/ name phone"></div>
	                  </div>
					  <div class="row form-group">
	                      <div class="col col-md-3"><label for="status" class=" form-control-label">Status</label></div>
	                      <div class="col-12 col-md-9">
	                        <select class="form-control" name="status">
	                          	<option value=""> All </option>
	                          	@foreach($status as $stat)
		                      	  <option value="{{ $stat->id }}" {{ $request->status == $stat->id? 'selected' : ''}}>
		                      	  	{{ $stat->_name }}
		                      	  </option>
		                        @endforeach
		                    </select>
	                      </div>
	                  </div>
	                  <div class="row form-group">
	                      <div class="col col-md-3"><label for="_period" class=" form-control-label">Period</label></div>
	                      <div class="col-11 col-md-8"><input id="" name="_period" class="form-control dateRangePicker" value="{{ $request->_period ? $request->_period : '' }}" autocomplete="false"></div>
	                  </div>                  
	                  <div class="row form-group">
	                      <div class="col col-md-3"><label for="paymentMethod" class=" form-control-label">Payment Method</label></div>
	                      <div class="col-12 col-md-9">
	                        <select class="form-control" name="paymentMethod">
	                          	<option value=""> All </option>
	                          	@foreach($payment_method as $pm)
		                      	  <option value="{{ $pm->id }}" {{ $request->paymentMethod == $pm->id? 'selected' : ''}}>
		                      	  	{{ $pm->_name }}
		                      	  </option>
		                        @endforeach
		                    </select>
	                      </div>
	                  </div>

	                  <div id="notprint">
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
	            	<table width="100%">
	            		<tr>
	            			<td width="50%"><h4><strong>Total Item</strong></h4></td>
	            			<td width="25%"><h4><strong>:</strong></h4></td>
	            			<td width="25%" align="right"><h4><strong>{{ $item }}</strong></h4></td>
	            		</tr>
	            		<tr>
	            			<td><h4><strong>Total Weight (Gram)</strong></h4></td>
	            			<td><h4><strong>:</strong></h4></td>
	            			<td align="right"><h4><strong>{{ $weight }} </strong></h4></td>
	            		</tr>	      
	               		<tr>
	            			<td colspan="3"><hr></td>	            			
	            		</tr>
						<tr>
	            			<td width="50%"><h4><strong>Total Item Amount</strong></h4></td>
	            			<td width="25%"><h4><strong>:</strong></h4></td>
	            			<td width="25%" align="right"><h4><strong>{{ number_format($total_item_amount, 0, '.', '.') }}</strong></h4></td>
	            		</tr>
	            		<tr>
	            			<td><h4><strong>Total Freight Amount</strong></h4></td>
	            			<td><h4><strong>:</strong></h4></td>
	            			<td align="right"><h4><strong>{{ number_format($total_weigth_amount, 0, '.', '.') }} </strong></h4></td>
	            		</tr>	      
	               		<tr>
	            			<td colspan="2"><hr></td>
	            			<td align="right" width="5px"><h3><strong>+</strong></h3></td>	            			
	            		</tr>
	            		<tr>
	            			<td width="50%"><h4><strong>Grand Total Amount</strong></h4></td>
	            			<td width="25%"><h4><strong>:</strong></h4></td>
	            			<td width="25%" align="right"><h4><strong>{{ number_format($grand_total, 0, '.', '.') }}</strong></h4></td>
	            		</tr>	            		      		
	            	</table>
	            </div>            
	        </div>
	    </div>
	</div>
	<div class="row">    
	    <div id="notprint2" align="right" class="col-sm-12">
	        <button type="button" class="btn btn-success" onclick="location.href=''"><strong>Export</strong></button>
	        <!-- <button type="button" class="btn btn-primary" onclick="printDiv('printable')"><strong>Print</strong></button> -->
	    </div>
	    <div class="col-sm-12">
	        <div class="card">  
	            <div class="card-header">
	                <strong class="card-title">List </strong>Sales
	            </div>
	            <div class="card-body">
	              <table class="table table-bordered" id="table" class="col-sm-12">
	                 <thead>
	                    <tr>
	                      <th width="10%">Order ID</th>
	                      <th width="10%">Date</th>
	                      <th width="15%">Email</th>                      
	                      <th width="15%">Total Item</th>
	                      <th width="5%">Total Weight</th>
	                      <th width="5%">Item Amount</th>
	                      <th width="5%">Freight Amount</th>
	                      <th width="15%">Total Amount</th>
	                    </tr>
	                 </thead>
	              </table>
	          <script>
	            $(function() {
	                 	var url_clean = "{{ url('report/sales/load-data?period='. $request->_period.'&status='. $request->status.'&paymentMethod='. $request->paymentMethod.'&keyword='. $request->keyword) }}"
	                 	var fix_url = url_clean.replace(/&amp;/g, '&');
	                  	$('#table').DataTable({
	                  	dom: 'Bfrtip',
				        buttons: [
				             'copyHtml5',
				             'excelHtml5',
				             'csvHtml5',
				             {
				                extend: 'pdfHtml5',
				                // messageTop: "Total Amount : \nTotal freight : \nGrand Total : ",
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
	                           { data: 'row_last_modified', name: 'row_last_modified' },
	                           { data: '_email', name: '_email' },
	                           { data: '_qty', name: '_qty' },
							   { data: 'product_weight', name: 'product_weight' },
	                           { data: '_total_amount', name: '_total_amount' },
	                           { data: '_freight_amount', name: '_freight_amount' },
	                           { data: '_grand_total', name: '_grand_total' }
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
		var stringNotToPrint = `	                  <div id="notprint">
	                  	<button type="submit" class="btn btn-primary"><strong>Search</strong></button>
	                  </div>`;
		var stringNotToPrint2 = `	    <div id="notprint2" align="right" class="col-sm-12">
	        <button type="button" class="btn btn-success" onclick="location.href=''"><strong>Export Excel</strong></button>
	        <button type="button" class="btn btn-primary" onclick="printDiv('printable')"><strong>Print</strong></button>
	    </div>`;

	    var prtContent = document.getElementById(sectionName);

        var allContent = prtContent.innerHTML;
        allContent = allContent.replace(stringNotToPrint, "");
        allContent = allContent.replace(stringNotToPrint2, "");

        var inlineCss = `
        	@media print{
				p {
				    font-family: "Comic Sans MS", cursive, sans-serif !important;
				}        		
        	}
		`;
        var WinPrint = window.open();
        allContent = '</head><body><div class="pageprint">' + allContent;
        allContent = '<link rel="stylesheet" href="assets/admin/assets/css/style.css" media="print">' + allContent;
        allContent = '<link rel="stylesheet" href="assets/admin/assets/css/bootstrap.min.css" media="print">' + allContent;
        allContent = '<style>' + inlineCss + '</style>' + allContent;
        allContent = '<base href="' + location.origin + '/">' + allContent;
        allContent = '<html><head><title></title>' + allContent;
        allContent = '<!DOCTYPE html>' + allContent;
        allContent += '</div></body></html>';
        console.log(allContent);
        WinPrint.document.write(allContent);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
	}
</script>
@endsection