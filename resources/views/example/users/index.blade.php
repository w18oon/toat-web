@extends('layouts.app')

@section('title', 'Ex: User')

@section('page-title')
    <h2>Example: Users</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Example</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Users</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('example.users.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a href="{{ route('example.users.export-excel') }}" class="btn  btn-sm btn-white">
                             Export Excel
                        </a>
                        <a href="{{ route('example.users.export-pdf') }}" class="btn  btn-sm btn-white">
                             Export PDF
                        </a>
                        <a href="{{ route('example.users.interface-error') }}"  class="btn btn-outline btn-danger btn-xs">
                        Ex. Interface Error
                        </a>
                    </div>
                    <h5>Users</h5>
                </div>
                <div class="ibox-content">
                    @include('example.users._table')
                </div>
            </div>
        </div>
    </div>
@endsection
