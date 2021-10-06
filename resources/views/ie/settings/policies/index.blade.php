@extends('layouts.app')

@section('title', 'Policies')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> {{ $category->name }} : {{ $sub_category->name }} : Policies</h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}"> {{ $category->name }} : Sub-Categories</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>{{ $sub_category->name }} : Policies</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        {{ $sub_category->name }} : Policies <br>
        <small>รายละเอียดประเภทการเบิกย่อย</small>
    </h3>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            <div class="row">
                <div class="col-md-6 b-r">
                    <div class="policy-bg-money">
                    @if($policy_expense)
                        {{-- ALREADY ENABLE TO USE POLICY NORMAL --}}
                        <div class="p-xl pm-xl text-center" style="min-height: 200px">
                            <div style="font-size: 15px;color:#888;" class="text-mute m-t-sm m-b-md">
                                <div>This sub-category use expense policy</div>
                                <div>ใช้งานเกณฑ์สำหรับการเบิกค่าใช้จ่ายแล้ว</div>
                            </div>
                            <div>
                                <a href="{{ route('ie.settings.policies.rates.index',[$category->category_id,$sub_category->sub_category_id,$policy_expense->policy_id]) }}" class="btn btn-resize btn-success">
                                    <i class="fa fa-edit"></i> Setting Expense Policy Rate
                                </a>
                                <a href="#" id="btn_disable_{{ $policy_expense->policy_id }}" data-policy-id="{{ $policy_expense->policy_id }}" class="btn btn-resize btn-outline btn-danger">
                                    <i class="fa fa-times"></i> Disable
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- NOT ENABLE TO USE POLICY NORMAL --}}
                        <div class="p-xl pm-xl text-center" style="min-height: 200px">
                            <div style="font-size: 15px;color:#888;" class="text-mute m-t-sm m-b-md">
                                <div>Click for enable to use expense policy</div>
                                <div>กดที่ปุ่มเพื่อเปิดใช้งานเกณฑ์การเบิกค่าใช้จ่าย</div>
                            </div>
                            <button id="btn_use_policy" class="btn btn-resize btn-success">
                                <i class="fa fa-check-square-o"></i> Use Expense Policy
                            </button>
                        </div>
                    @endif
                    </div>

                    <hr class="show-sm-only show-xs-only">

                </div>
                <div class="col-md-6">
                    <div class="policy-bg-road">
                    @if($policy_mileage)
                        {{-- ALREADY ENABLE TO USE MILEAGE POLICY NORMAL --}}
                        <div class="p-xl pm-xl text-center" style="min-height: 200px">
                            <div style="font-size: 15px;color:#888;" class="text-mute m-t-sm m-b-md">
                                <div>This sub-category use mileage policy </div>
                                <div>ใช้งานเกณฑ์สำหรับการเบิกเงินตามระยะทางแล้ว</div>
                            </div>
                            <div>
                                <a href="{{ route('ie.settings.policies.rates.index',[$category->category_id,$sub_category->sub_category_id,$policy_mileage->id]) }}" class="btn btn-resize btn-primary">
                                    <i class="fa fa-edit"></i> Setting Mileage Policy Rate
                                </a>
                                <a href="#" id="btn_disable_{{ $policy_mileage->policy_id }}" data-policy-id="{{ $policy_mileage->policy_id }}" class="btn btn-resize btn-outline btn-danger">
                                    <i class="fa fa-times"></i> Disable
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- NOT ENABLE TO USE MILEAGE POLICY NORMAL --}}
                        <div class="p-xl pm-xl text-center" style="min-height: 200px">
                            <div style="font-size: 15px;color:#888;" class="text-mute m-t-sm m-b-md">
                                <div>Click for enable to use mileage policy</div>
                                <div>กดที่ปุ่มเพื่อเปิดใช้งานเกณฑ์การเบิกเงินตามระยะทาง</div>
                            </div>
                            <button id="btn_use_policy_mileage" class="btn btn-resize btn-primary">
                                <i class="fa fa-check-square-o"></i> Use Mileage Policy
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@include('ie.settings.policies._modal_use_policy')

@endsection

@section('scripts')
@parent
    <script>
        $(document).ready(function(){

            // USE POLICY
            $("#btn_use_policy").click(function(){
                var type = 'EXPENSE';
                showModalUsePolicy(type);
            });

            // USE MILEAGE POLICY
            $("#btn_use_policy_mileage").click(function(){
                var type = 'MILEAGE';
                showModalUsePolicy(type);
            });

            function showModalUsePolicy(type){
                $("#modal-use-policy-form").modal('show');
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/policies/create",
                    type: 'GET',
                    data: { type : type },
                    beforeSend: function( xhr ) {
                        $("#modal-body-use-policy-form").html('\
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
                    $("#modal-body-use-policy-form").html(result);
                });
            }

            // DISABLE POLICY EVENT
            $("[id^='btn_disable_']").click(function(){
                let id = $(this).attr('data-policy-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to use this policy!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, disable it!",
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
                          url:  "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/policies/"+id+"/inactive",
                          data: {
                            _token: "{{ csrf_token() }}",
                          },
                          beforeSend: function() {
                            //
                          },
                          success: function (data) {
                            swal({
                              title: "Disabled !",
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

        });
    </script>
@endsection