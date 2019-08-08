<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap 3.3.6 -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/3.4/examples/non-responsive/non-responsive.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin-lte/dist/css/AdminLTE.css?v=1">
    <link rel="stylesheet" href="/admin-lte/dist/css/skins/skin-blue.css?v=1">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=1"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=1"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://www.html5tricks.com/demo/jquery-calendar-with-tooltip/css/calendar.css?v=1">
    <link rel="stylesheet" href="/css/datepicker.css?v=1">
    <link rel="stylesheet" href="/css/global.css?v=1">
    <!-- jQuery 3.1.1 -->
    <script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="{{ asset('js/jquery-ui-1.10.4.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/echarts.js') }}"></script>

    <script src="{{ asset('js/comm.js?v=1') }}"></script>
    <script src="{{ asset('js/calendar.js?v=1') }}"></script>
    <script src="{{ asset('js/datepicker.all.js?v=1') }}"></script>


    {{--<script src="https://echarts.baidu.com/echarts2/doc/example/www2/js/echarts-all.js"></script>--}}
</head>
<body class="hold-transition skin-blue no-bg" ng-app="app">
<div class="wrapper" ng-controller="pageCtrl">
    @include('layouts._header_m')
    {{--@include('layouts._sidebar')--}}
    @include('layouts._content')
    @include('layouts._footer')
</div>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-lte/dist/js/adminlte.js?v=1"></script>
<script src='https://webapi.amap.com/maps?v=1.4.10&key=9ab87268e7b0963b097a9c6c7ddd06d9'></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.1.0/echarts-en.common.js"></script>--}}
</body>
</html>
