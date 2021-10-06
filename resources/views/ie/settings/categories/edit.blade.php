@extends('layouts.app')

@section('title', 'Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm">
        Edit Category : {{ $category->name }} <br>
        <small>แก้ไขข้อมูลประเภทการเบิก</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit Category : {{ $category->name }}</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        Edit Category : {{ $category->name }} <br>
        <small>แก้ไขข้อมูลประเภทการเบิก</small>
    </h3>
@stop

@section('page-title-action')
    @if(!$category->isAdvanceOver())
    <div class="text-right m-t-lg">
        {!! Form::open(['route' => ['ie.settings.categories.remove',$category->category_id],
                    'method' => 'POST',
                    'id' => 'form-remove-category']) !!}

            <button type="submit" class="btn btn-danger">
                <i class="fa fa-times"></i> Remove
            </button>

        {!! Form::close() !!}
    </div>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::model($category, ['route' => ['ie.settings.categories.update', $category->category_id], 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
                  @include('ie.settings.categories._form')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#form-remove-category").submit(function( event ) {
                var form = this;
                swal({
                    html: true,
                    title: 'Are you sure ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">You will not able to recover this category.</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        form.submit();
                    }else{
                        $("button[type='submit']").removeAttr('disabled');
                    }
                });
                event.preventDefault();
            });
        });
    </script>
@endsection