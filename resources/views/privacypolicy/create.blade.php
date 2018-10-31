@extends('layouts.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2><strong></strong> Website Management - Privacy Policy</h2>            
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('privacypolicy.form')
    </div>
</div>
@endsection