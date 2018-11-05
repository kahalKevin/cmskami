@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Update</strong> Category&Product - Product</h2>			
	</div>
</div>
<br><br><br>
<div class="row">
    <div class="col-sm-12">
	    <div align="right" class="col-sm-12">
			
	    </div>
        @include('products.form')
    </div>    
</div>
@endsection