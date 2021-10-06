<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - @yield('title') </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

</head>
<body>
<div id="app">
  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">


            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    @yield('page-title')
                </div>
                <div class="col-lg-4 text-right pt-4">
                    @yield('page-title-action')
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                @include('shared._success_message')
                @include('shared._error_message')

                <!-- Main view  -->
                @yield('content')
            </div>


            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->
</div>

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/vendor/app.js') !!}" type="text/javascript"></script>

@section('scripts')
@show

</body>
</html>
