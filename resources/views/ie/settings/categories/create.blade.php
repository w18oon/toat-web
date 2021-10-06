@extends('layouts.app')

@section('title', 'Categories')

@section('page-title')
    {{-- PC --}}
    {{-- <h2 class="hidden-xs hidden-sm">
        <div>Create New Category</div>
        <div><small>สร้างข้อมูลประเภทการเบิกใหม่</small></div>
    </h2> --}}
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="active">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="active">
            <strong>Create New Category </strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    {{-- <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        <div>Create New Category</div>
        <div><small>สร้างข้อมูลประเภทการเบิกใหม่</small></div>
    </h3> --}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::open(['route' => ['ie.settings.categories.store'], 'class' => 'form-horizontal']) !!}
                  @include('ie.settings.categories._form')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
