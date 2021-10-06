@extends('layouts.blank')

@section('title', 'Login')

@section('content')


    <div class="loginColumns animated fadeInDown">
        <div class="row">

            {{-- {{ var_dump('zz', Session::all()) }} --}}
            @if (Session::has('err_login') && Session::get('err_login'))
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <li>{!! Session::get('err_login') !!}</li>
                    </ul>
                </div>
            </div>
            @endif

            <div class="col-md-6 text-center">
                <p class="logo-name-mini hidden-xs" style="color: #ccc;">
                    TOAT SERVICE
                </p>
                <p class="logo-name-mini show-xs-only" style="font-size:50px;color: #ccc;">
                    TOAT SERVICE
                </p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">

                    <form class="m-t" role="form" method="post" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" required="" name="username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" required="" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        {{-- <a href="#">
                            <small>Forgot password?</small>
                        </a>

                        <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> --}}
                    </form>
                    {{-- <p class="m-t">
                        <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
                    </p> --}}
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright MCR Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2020-2021</small>
            </div>
        </div>
    </div>
@endsection
