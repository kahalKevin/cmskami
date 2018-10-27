@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Create</strong> Category&Product - Category</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
        @include('categories.form')
    </div>    
</div>
@endsection