@extends('layouts.admin_template')

@section('content')

<div class="">
	<div class="col-sm-12">
		<h2><strong>Items</strong> Order Management</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">

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

    </div>    
</div>
@endsection    	