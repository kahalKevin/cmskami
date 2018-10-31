@extends('layouts.admin_template')

<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/flag-icon.min.css")}}">
<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/cs-skin-elastic.css")}}">
<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/lib/chosen/chosen.min.css")}}">

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Create</strong> Category&Product - Product</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
        @include('products.form')
    </div>    
</div>
@endsection