<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SuperStore CMS</title>
    <meta name="description" content="CMS KIta - Kevin">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="/assets/admin/images/favicon.png">
    <link rel="shortcut icon" href="/assets/admin/images/favicon.png">

    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/normalize.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/themify-icons.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/pe-icon-7-filled.css")}}">

    <link href="{{ asset("/assets/admin/assets/calendar/fullcalendar.css")}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/style.css")}}">
</head>
<body>
    <!-- Sidebar -->
     @include('layouts.sidebar')

    <!-- Right Panel --> 
    <div id="right-panel" class="right-panel">

    <!-- Header -->
    @include('layouts.header')
        <!-- Content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        <!-- Content -->

        <div class="clearfix"></div>

        <!-- Footer -->
        @include('layouts.footer')

    </div><!-- /#right-panel -->


    <script src="{{ asset("/assets/admin/assets/js/vendor/jquery-2.1.4.min.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/popper.min.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/plugins.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/main.js")}}"></script>

    <script src="{{ asset("/assets/admin/assets/js/lib/moment/moment.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/calendar/fullcalendar.min.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/calendar/fullcalendar-init.js")}}"></script>
<div id="container">
</div>
</body>
</html>
