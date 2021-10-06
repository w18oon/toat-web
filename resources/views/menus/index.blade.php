@extends('layouts.app')

@section('title', 'Menus')

@section('page-title')
    <h2>Menus</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Menus</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('menus.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Menus</h5>
                </div>
                <div class="ibox-content">
                    @include('menus._table')
                </div>
            </div>
        </div>
    </div>
@endsection
