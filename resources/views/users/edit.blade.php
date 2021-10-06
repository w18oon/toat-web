@extends('layouts.app')

@section('title', 'User')

@section('page-title')
    <h2><x-get-program-code url="/users" /> User: Edit</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('example.users.index') }}">users</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit</strong>
        </li>
    </ol>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Users</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['users.update', $user] , "method" => "put" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        @include('users._form')

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-sm btn-primary" type="submit"> Save </button>
                                    <a href="{{ route('users.index') }}" type="button" class="btn btn-sm btn-white"> Cancel </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
