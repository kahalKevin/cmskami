@extends('layouts.admin_template')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2><strong></strong> Website Management - Add Ads/Inventory Banner</h2>			
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('adsbanners.form')
    </div>    
</div>
@endsection