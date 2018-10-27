@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Update</strong> Master Data - League</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('leagues.form')
    </div>    
</div>
@endsection