@extends('layouts.app')

@section('title', 'User')

@section('page-title')
    <h2>
        <x-get-program-code url="/users" /> Users
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Users</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Users</h5>
                </div>
                <div class="ibox-content">
                    @include('users._table')
                </div>
            </div>
        </div>
    </div>
@endsection
