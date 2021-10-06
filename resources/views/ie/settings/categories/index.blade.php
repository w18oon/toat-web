@extends('layouts.app')

@section('title', 'Categories')

@section('page-title')
    <h2>
        Categories  <br>
        <small>ประเภทการเบิก</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Categories</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <a href="{{ route('ie.settings.categories.create') }}"
            class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> New Category
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="m-l-md m-r-md">
                    @foreach($categories as $category)
                    <div class="forum-item" style="margin: 7px 0; padding: 7px 0 10px;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="forum-icon-policy">
                                    <i class="fa {{ $category->icon }}"></i>
                                </div>
                                <div class="forum-item-policy-title">
                                    {{ $category->name }}
                                </div>
                                <div class="forum-sub-title clearfix m-b-xs" style="margin-left: 70px;">
                                    {{ $category->description }}
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}" class="btn btn-resize btn-white">
                                    <i class="fa fa-th-list m-r-xs"></i> Sub-Categories
                                </a>
                                <a href="{{ route('ie.settings.categories.edit', $category) }}" class="btn btn-resize btn-white">
                                    <i class="fa fa-edit m-r-xs"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection