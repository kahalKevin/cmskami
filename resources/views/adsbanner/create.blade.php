@extends('layouts.admin_template')
        <link rel="stylesheet" href="{{ asset("/css/bootstrap-datetimepicker.min.css")}}">
        <script type="text/javascript" src="{{ asset("/js/jquery.min.js")}}"></script>
        <script type="text/javascript" src="{{ asset("/assets/admin/assets/js/lib/moment/moment.js")}}"></script>
        <script type="text/javascript" src="{{ asset("/js/bootstrap.min.js")}}"></script>
        <script type="text/javascript" src="{{ asset("/js/bootstrap-datetimepicker.min.js")}}"></script>
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2><strong></strong> Website Management - Add Ads/Inventory Banner</h2>            
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
                @include('adsbanner.form')
    </div>    
</div>
@endsection