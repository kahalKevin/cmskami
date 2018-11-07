@extends('layouts.admin_template')

@section('content')

<div class="">
	<div class="col-sm-12">
		<h2><strong>Update</strong> Order Management - Detail Order</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
		<div class="card">
		    <div class="card-header">
		        <strong class="card-title">
	            	<form class="form-horizontal">
						<div class="row form-group">
	                        <div class="col col-md-2"><label class=" form-control-label">Order Id#</label></div>
	                        <div class="col-7 col-md-4">
	                        	<input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control" value="{{ $order->id }}">
	                        </div>
	                    </div>
	                    <div class="row form-group">
	                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Grand</label></div>
	                        <div class="col-7 col-md-4">
	                        	<input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control" value="Rp {{ number_format($order->_grand_total, 2) }}">
	                        </div>
	                    </div>
	            	</form>		        
		        </strong>
		    </div>
		    <div class="card-body">
		        <!-- Credit Card -->
		        <div id="pay-invoice">
		            <div class="card-body">
						<div class="custom-tab">
		                    <nav>
		                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
		                            <a class="nav-item nav-link active" id="custom-nav-buyer-info-tab" data-toggle="tab" href="#custom-nav-buyer-info" role="tab" aria-controls="custom-nav-buyer-info" aria-selected="true">Buyer Info</a>
		                            <a class="nav-item nav-link" id="custom-nav-shipment-info-tab" data-toggle="tab" href="#custom-nav-shipment-info" role="tab" aria-controls="custom-nav-shipment-info" aria-selected="false">Shipment Info</a>
		                            <a class="nav-item nav-link" id="custom-nav-meta-info-tab" data-toggle="tab" href="#custom-nav-meta-info" role="tab" aria-controls="custom-nav-meta-info" aria-selected="false">Meta Info</a>
		                            <a class="nav-item nav-link" id="custom-nav-payment-info-tab" data-toggle="tab" href="#custom-nav-payment-info" role="tab" aria-controls="custom-nav-payment-info" aria-selected="false">Payment Info</a>
		                        </div>
		                    </nav>
		                    <div class="tab-content pl-3 pt-2" id="nav-tabContent"> 
		                    	<br>
		                        <div class="tab-pane fade show active" id="custom-nav-buyer-info" role="tabpanel" aria-labelledby="custom-nav-buyer-info-tab">
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Type</label>
		                            	<input type="text" id="" disabled="" value="{{ isset($order->user_id) ? 'Registered User' : 'Guest' }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Email</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_email }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Fullname</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_receiver_name }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Gender</label>
		                            	<input type="text" id="" disabled="" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Phone</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_receiver_phone }}" class="form-control">
		                            </div>
                                </div>
                                
                                <div class="tab-pane fade" id="custom-nav-shipment-info" role="tabpanel" aria-labelledby="custom-nav-shipment-info-tab">
                                	{{ Form::open(array('url'=>'order-management/order/confirm-shipment-order/'.$order->id , 'method' => 'POST')) }}
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Name</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_receiver_name }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Phone</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_receiver_phone }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Address</label>
		                            	<textarea name="textarea-input" disabled="" id="textarea-input" rows="9" class="form-control">{{ $order->_address }}</textarea>
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Kota</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_kota }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Kecamatan</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_kecamatan }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Kelurahan</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_kelurahan }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Kode Pos</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_kode_pos }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Freight Provider</label>
		                            	<input type="text" id="" disabled="" value="{{ $freight_provider->_name }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Freight Amount</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_freight_amount }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">AWB No#</label>
		                            	<input type="text" id="_freight_awb_no" name="_freight_awb_no" value="{{ $order->_freight_awb_no }}" class="form-control">
		                            </div>
		                            <button type="submit" class="btn btn-success"><strong>Proccess</strong></button>
		                            {!! Form::close() !!}		                            
		                        </div>
		                        
		                        <div class="tab-pane fade" id="custom-nav-meta-info" role="tabpanel" aria-labelledby="custom-nav-meta-info-tab">
		                        	{{ Form::open(array('url'=>'order-management/order/update-internal-note-order/'.$order->id , 'method' => 'POST')) }}
		                        	<div class="form-group">
		                            	<label for="" class=" form-control-label">Status</label>
		                            	<input type="text" id="" disabled="" value="{{ $status_order->_name }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Order Date</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->created_at }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Payment Date</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_payment_at }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Confirm Date</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_confirm_at }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Shipment Date</label>
		                            	<input type="text" id="" disabled="" value="" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Delivered At</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->_delivered_at }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Internal Note</label>
		                            	<textarea name="_internal_note" id="_internal_note" rows="9" class="form-control">{{ $order->_internal_note }}</textarea>
		                            </div>
		                            <button type="submit" class="btn btn-success"><strong>Update</strong></button>
		                            {!! Form::close() !!}
		                        </div>
		                        
		                        <div class="tab-pane fade" id="custom-nav-payment-info" role="tabpanel" aria-labelledby="custom-nav-payment-info-tab">
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Method</label>
		                            	<input type="text" id="" 1 disabled="" value="{{ $payment_method->_name }}"	class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Pg. Provider</label>
		                            	<input type="text" id="" disabled="" value="{{ isset($payment_gateway) ? $payment_gateway->_name : '' }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Pg. Trx Ref No</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->payment_gateway_trx_ref_no }}" class="form-control">
		                            </div>
									<div class="form-group">
		                            	<label for="" class=" form-control-label">Pg. Status</label>
		                            	<input type="text" id="" disabled="" value="{{ $order->payment_gateway_callback_status }}" class="form-control">
		                            </div>
		                            <div class="form-group">
		                            	<label for="" class=" form-control-label">Pg. Callback Raw</label>
		                            	<textarea name="textarea-input" disabled="" id="textarea-input" rows="9" class="form-control">{{ $order->payment_gateway_callback_raw }}</textarea>
		                            </div>
		                        </div>		                        
		                    </div>

		                </div>
		            </div>
		        </div>

		    </div>
		</div>
		<div class="card">
	        <div class="card-header">
	            <strong class="card-title">Item Order</strong>
	        </div>
	        <div class="card-body">
	            <table class="table table-striped">
	                <thead>
	                    <tr>
	                        <th scope="col">#</th>
	                        <th scope="col">Image</th>
	                        <th scope="col">Name</th>
	                        <th scope="col">Weight</th>
	                        <th scope="col">Qty</th>
	                        <th scope="col">Price</th>
	                        <th scope="col">Total</th>
	                        <th scope="col">Cart Date</th>
	                        <th scope="col">Action</th>	                        
	                    </tr>
	                </thead>
	                <tbody>
	                	@php
							$i = 1
						@endphp
	                	@foreach ($order_detail_list as $odl)
						    <tr>
		                        <th scope="row">{{ $i }}</th>
		                        <td>
		                        @if ($odl->product_image_url != null && $odl->product_image_real_name != null)
							        <a target="_blank" href="{{ $odl->product_image_url }}">{{ $odl->product_image_real_name }} <a>
							    @endif		                        	
		                        </td>
		                        <td>{{ $odl->product_name }}</td>
		                        <td>{{ $odl->product_weight }}</td>
								<td>{{ $odl->_qty }}</td>
		                        <td>{{ $odl->product_price }}</td>
		                        <td>{{ $odl->product_price * $odl->_qty }}</td>
		                        <td>{{ $odl->created_at }}</td>
		                        <td>
		                        	<a href=/category-product/product/{{ $odl->product_id }}/edit class="btn btn-primary"role="button">View Item Ordered<a>
		                        </td>		                        
		                    </tr>
	                	@php
							$i++
						@endphp		                    
						@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	    <div class="row">
		    <div class="col-sm-6" align="right">
		    	{{ Form::open(array('url'=>'order-management/order/ignore-order/'.$order->id , 'method' => 'POST')) }}
	    			<button type="submit" class="btn btn-danger"><strong>Ignore</strong></button>
				{!! Form::close() !!}	
		    </div>
			<div class="col-sm-6">
			    {{ Form::open(array('url'=>'order-management/order/confirm-order/'.$order->id , 'method' => 'POST')) }}
			    	<input type="hidden" id="" value="yes" name="isFromDetail" class="form-control">
			    	<button type="submit" class="btn btn-success"><strong>Confirm</strong></button>
				{!! Form::close() !!}		    
		    </div>	    	
		</div>		
    </div>    
</div>
@endsection