<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - @yield('title') </title>

    <link rel="shortcut icon" href="/images/title.png" type="image/png" />
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="" >
    {{-- <div id="app"> --}}
        <div class="light-grey-bg" style="height:100%;">
            {{-- <div class="wrapper wrapper-content animated fadeInRight"> --}}
                @yield('content')
        </div>
            {{-- </div> --}}
        {{-- </div> --}}
    {{-- </div> --}}

    <script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/vendor/app.js') !!}" type="text/javascript"></script>

@section('scripts')
@show

</body>
</html>
