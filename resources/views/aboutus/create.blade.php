@extends('layouts.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2><strong></strong> Website Management - About Us</h2>            
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('aboutus.form')
    </div>
</div>
@endsection