@extends('layouts.app')

@section('title', 'Sub-Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm">
        {{ $category->name }} : Create New Sub-Category <br>
        <small>สร้างประเภทการเบิกย่อยใหม่</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}"> {{ $category->name }} : Sub-Categories</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Create New Sub-Category</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        <strong>Create New Sub-Category</strong> <br>
        <small>สร้างประเภทการเบิกย่อยใหม่</small>
    </h3>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            {!! Form::open(['route' => ['ie.settings.sub-categories.store',$category->category_id], 'class' => 'form-horizontal']) !!}
              @include('ie.settings.sub-categories._form')
            {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
