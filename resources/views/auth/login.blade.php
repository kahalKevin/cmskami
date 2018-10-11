<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Superstrore CMS - Login</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/favicon.png">
    <link rel="shortcut icon" href="images/favicon.png"> 

    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/normalize.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/themify-icons.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/pe-icon-7-filled.csss")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/flag-icon.min.css")}}">
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/cs-skin-elastic.css")}}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/style.css")}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <h1><b>SuperStore <strong>CMS</strong></b></h1>
                        <!-- <img class="align-content" src="images/logo.png" alt=""> -->
                    </a>
                </div>
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}">
                    @csrf            
                        <div class="form-group">
                            <label>Email address</label>
                            <input id="_email" type="email" class="form-control{{ $errors->has('_email') ? ' is-invalid' : '' }}" name="_email" value="{{ old('_email') }}" required autofocus placeholder="Email">
                            @if ($errors->has('_email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('_email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label class="pull-right">
                                <a href="#">Forgotten Password?</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset("/assets/admin/assets/js/vendor/jquery-2.1.4.min.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/popper.min.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/plugins.js")}}"></script>
    <script src="{{ asset("/assets/admin/assets/js/main.js")}}"></script>


</body>
</html>
