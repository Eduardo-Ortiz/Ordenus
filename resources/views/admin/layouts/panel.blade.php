<!DOCTYPE html>
<html lang="es">

<head>

    <meta  charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ordenus - Admin Panel</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}" >

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

    <!-- MetisMenu CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/metisMenu.min.css') }}" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/sb-admin-2.css') }}" />

    <!-- Morris Charts CSS -->
    <!-- <link href="../vendor/morrisjs/morris.css" rel="stylesheet">-->

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Passion+One" rel="stylesheet">

    <!-- Bootstrap Toggle -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-toggle.min.css') }}" />

    <!-- Alertify -->
    <link rel="stylesheet" href="{{ URL::asset('css/alertify.min.css') }}" />

    <!-- Alertify -->
    <link rel="stylesheet" href="{{ URL::asset('css/alertify.min.css') }}" />

    <!-- Alertify -->
    <link rel="stylesheet" href="{{ URL::asset('css/alertify-bootstrap.min.css') }}" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{URL::asset('js/html5shiv.js')}}"></script>
    <script type="text/javascript" src=" {{URL::asset('js/respond.min.js')}}"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    @include('admin.layouts.navbar')

    <div id="page-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script type="text/javascript" src="{{URL::asset('js/jquery.min.js')}}"></script>

<!-- jQuery for image preview-->
<script type="text/javascript" src="{{URL::asset('js/image-preview.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>


<!-- Metis Menu Plugin JavaScript -->
<script type="text/javascript" src="{{URL::asset('js/metisMenu.min.js')}}"></script>

<!-- Morris Charts JavaScript -->
<!--<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../data/morris-data.js"></script>-->

<!-- Custom Theme JavaScript -->
<script type="text/javascript" src="{{URL::asset('js/sb-admin-2.js')}}"></script>

<!-- Vue.js -->
<script type="text/javascript" src="{{URL::asset('js/vue.js')}}"></script>

<!-- Boostrap Toggle -->
<script type="text/javascript" src="{{URL::asset('js/bootstrap-toggle.min.js')}}"></script>

<!-- Alertify -->
<script type="text/javascript" src="{{URL::asset('js/alertify.min.js')}}"></script>

<script type="text/javascript" src="{{URL::asset('js/axios.min.js')}}"></script>





</body>

@yield('footer')

</html>