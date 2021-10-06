@extends('layouts.app')

@section('title', 'Sub-Categories Informations')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm">
        {{ $category->name }} - {{ $sub_category->name }} : Informations <br>
        <small>รายละเอียดประเภทการเบิกย่อย</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}"> {{ $category->name }} : Sub-Categories</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>{{ $sub_category->name }} : Informations</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        {{ $sub_category->name }} : Informations <br>
        <small>รายละเอียดประเภทการเบิกย่อย</small>
    </h3>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
        <div class="row">

            {{-- SHOW ONLY PC SCREEN --}}
            <div class="col-md-3 b-r hidden-xs hidden-sm">
                <h4>Sub-Category Detail</h4>
                <ul class="list-group clear-list m-t">
                    <li class="list-group-item fist-item">
                        <span class="pull-right">
                            {{ $sub_category->name }}
                        </span>
                        Name :
                    </li>
                    <li class="list-group-item fist-item">
                        <span class="pull-right">
                            {{ $sub_category->description }}
                        </span>
                        Description :
                    </li>
                    <li class="list-group-item fist-item">
                        <span class="pull-right">
                            {{ dateFormatDisplay($sub_category->start_date) }}
                        </span>
                        Start Date :
                    </li>
                    <li class="list-group-item fist-item">
                        <span class="pull-right">
                            {{ dateFormatDisplay($sub_category->end_date) }}
                        </span>
                        End Date :
                    </li>
                    <li class="list-group-item fist-item">
                        <span class="pull-right">
                            {!! activeIcon($sub_category->active) !!}
                        </span>
                        Active :
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                <h4 class="clearfix">
                    Additional Information
                    <span class="pull-right">
                        <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" href="#modal-create-form">
                            <i class="fa fa-plus"></i> Add New
                        </button>
                    </span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th class="text-center" width="10%">
                                    <div class="hidden-xs">REQ.</div>
                                    <div class="hidden-xs"><small>จำเป็น</small></div>
                                </th>
                                <th width="25%">
                                    <div class="hidden-xs hidden-sm">Attribute Name</div>
                                    <div class="hidden-xs hidden-sm"><small>ชื่อแอตทริบิวต์</small></div>
                                    <div class="show-xs-only show-sm-only">Attribute Name / Value</div>
                                    <div class="show-xs-only show-sm-only"><small>ชื่อแอตทริบิวต์ / ข้อมูล</small></div>
                                </th>
                                <th class="hidden-xs hidden-sm">
                                    <div>Purpose</div>
                                    <div><small>จุดประสงค์</small></div>
                                </th>
                                <th class="hidden-xs" width="15%">
                                    <div>Type</div>
                                    <div><small>ประเภทข้อมูล</small></div>
                                </th>
                                <th class="hidden-xs hidden-sm" width="15%">
                                    <div>Value</div>
                                    <div><small>ข้อมูล</small></div>
                                </th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($sub_category_infos) > 0)
                            @foreach ($sub_category_infos as $sub_category_info)
                                <tr>
                                    <td class="text-center text-danger">
                                        {{ ($sub_category_info->required)? '*' : '' }}
                                    </td>
                                    <td style="white-space: normal;">
                                        {{ $sub_category_info->attribute_name }}
                                        <span class="show-sm-only show-xs-only small">
                                            <br>
                                            @if($sub_category_info->form_type == 'date')
                                                {{ $sub_category_info->form_value ? dateFormatDisplay(implode(', ', json_decode($sub_category_info->form_value))) : '' }}
                                            @else
                                                {{ $sub_category_info->form_value ? implode(', ', json_decode($sub_category_info->form_value)) : '' }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="small hidden-xs hidden-sm">{{ $sub_category_info->purpose }}</td>
                                    <td class="small hidden-xs">{{ $listFormTypes[$sub_category_info->form_type] }}</td>
                                    <td class="small hidden-xs hidden-sm">
                                    @if($sub_category_info->form_type == 'date')
                                        {{ $sub_category_info->form_value ? dateFormatDisplay(implode(', ', json_decode($sub_category_info->form_value))) : '' }}
                                    @else
                                        {{ $sub_category_info->form_value ? implode(', ', json_decode($sub_category_info->form_value)) : '' }}
                                    @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="#" id="btn_edit_{{ $sub_category_info->sub_category_info_id }}" data-info-id="{{ $sub_category_info->sub_category_info_id }}" class="btn btn-outline btn-warning btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" id="btn_delete_{{ $sub_category_info->sub_category_info_id }}" data-info-id="{{ $sub_category_info->sub_category_info_id }}" class="btn btn-outline btn-danger btn-xs">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="6">
                                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if(isset($sub_category_infos))
                <div class="text-right">
                    {{ $sub_category_infos->links() }}
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

{{-- <style>
    .tooltip-inner {
        min-width: 250px;
        text-align: left;
    }
</style> --}}

@include('ie.settings.sub-categories.infos._modal_create')
@include('ie.settings.sub-categories.infos._modal_edit')
@endsection

@section('scripts')
@parent
    <script>
        $(document).ready(function(){

            bindEventFormType('create');

            $("[data-toggle=tooltip]").tooltip({ placement: 'right'});

            // EDIT RATE EVENT
            $("[id^='btn_edit_']").click(function(){
                $("#modal-edit-form").modal('show');
                let id = $(this).attr('data-info-id');
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/infos/"+id+"/edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal-body-edit-form").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                    }
                })
                .done(function(result) {
                    $("#modal-body-edit-form").html(result);
                    $("#modal-body-edit-form").find("[data-toggle=tooltip]").tooltip({ placement: 'right'});
                    bindEventFormType('edit');
                });
            });

            // DELETE RATE EVENT
            $("[id^='btn_delete_']").click(function(){
                let id = $(this).attr('data-info-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this info!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                          type: "post",
                          url:  "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/infos/"+id+"/inactive",
                          data: {
                            _token: "{{ csrf_token() }}",
                          },
                          beforeSend: function() {
                            //
                          },
                          success: function (data) {
                            swal({
                              title: "Deleted !",
                              text: "this page will refresh in 2 seconds.",
                              type: "success",
                              timer: 2000,
                              showConfirmButton: false
                            },function(){
                                location.reload();
                            });
                          },
                          error: function(evt, xhr, status) {
                              swal(evt.responseJSON.message, null, "error");
                          },
                          complete: function(data) {
                              //
                          }
                      });
                    }
                });
            });

            function bindEventFormType(method)
            {
                var inputId,divResultId,btnId;
                if(method == 'create'){
                    inputId = "ddl_form_type_create";
                    divResultId = "div_txt_form_value_create";
                    btnId = "btn_create";
                }else{
                    inputId = "ddl_form_type_edit";
                    divResultId = "div_txt_form_value_edit";
                    btnId = "btn_edit";
                }
                $("#"+inputId).change(function(){
                    var form_type = $("#"+inputId+" option:selected").val();
                    var url = "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/input_form_type/"+form_type;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function( xhr ) {
                            $("input[name='form_value'],div.bootstrap-tagsinput > input").attr("disabled","disabled");
                            $("#progress_modal").removeClass("hide");
                            $("#"+btnId).attr("disabled","disabled");
                        }
                    })
                    .done(function(result) {
                        $("#"+divResultId).html(result);
                        $("#progress_modal").addClass("hide");
                        $("#"+btnId).removeAttr("disabled");
                    });
                });
            }
        });
    </script>
@endsection