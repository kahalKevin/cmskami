@extends('layouts.admin_template')
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2><strong></strong> Website Management - Term Of Use</h2>            
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('termofuse.form')
    </div>
</div>
@endsection