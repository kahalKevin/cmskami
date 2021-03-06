@extends('layouts.admin_template')
<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/flag-icon.min.css")}}">
<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/cs-skin-elastic.css")}}">
<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/lib/chosen/chosen.min.css")}}">
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Update</strong> Category & Product - Product</h2>			
	</div>
</div>
<br><br><br>
<div class="row">
    <div class="col-sm-12">
	    <div align="right" class="col-sm-12">
			<a href="{{ url('/category-product/product-gallery?product_id='.$product->id) }}" class="btn btn-lg btn-success"><strong>Manage Gallery </strong>{{$product->_name}}</a>
			<a href="{{ url('/category-product/product-stock?product_id='.$product->id) }}" class="btn btn-lg btn-warning"><strong>Manage Stock </strong>{{$product->_name}}</a>			
	    </div>
        @include('products.form')
    </div>    
</div>
@endsection