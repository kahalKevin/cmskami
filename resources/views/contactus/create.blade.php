@extends('layouts.admin_template')
<script src="/ckeditor/ckeditor.js"></script>
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2><strong></strong> Website Management - Contact Us</h2>            
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('contactus.form')
    </div>
</div>
@endsection