<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HỆ THỐNG BÁN CLONE | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>HỆ THỐNG BÁN CLONE</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="social-auth-links text-center">
            <a href="{{url('/redirect')}}" class="btn btn-block btn-social btn-facebook btn-flat">
                <i class="fa fa-facebook"></i> Sign in using Facebook
            </a>
            <!--            <a href="#" class="btn btn-block btn-social btn-google btn-flat">-->
            <!--                <i class="fa fa-google-plus"></i> Sign in using Google-->
            <!--            </a>-->
        </div>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('awesome/css/font-awesome.min.css') }}" />
<!-- Theme style -->
<link rel="stylesheet" type="text/css" href="{{ asset('toastr/toastr.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('alt/skins.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('alt/AdminLTE.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('alt/style.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('js/pace/pace.min.css') }}" />
<script src="{{ asset('js/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('alt/adminlte.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/lucdeptrai.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
