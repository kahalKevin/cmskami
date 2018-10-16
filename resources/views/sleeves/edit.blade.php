@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Update</strong> Master Date - Sleeve</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('sleeves.form')
    </div>    
</div>
@endsection