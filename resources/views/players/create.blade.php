@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong>Create</strong> Master Data - Player</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('players.form')
    </div>    
</div>
@endsection