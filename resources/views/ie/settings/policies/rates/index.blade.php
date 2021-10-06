@extends('layouts.app')

@section('title', 'Policy Rates')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> {{ $sub_category->name }} : Policy Rates</h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}"> {{ $category->name }} : Sub-Categories</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.policies.index',[$category->category_id,$sub_category->sub_category_id]) }}">{{ $sub_category->name }} : Policies</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
                {{ $policy->type == 'MILEAGE' ? 'Mileage ':'' }} Rates
            </strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        {{ $sub_category->name }} :{{ $policy->type == 'MILEAGE' ? 'Mileage ':'' }} Rates <br>
        {{-- <small>รายละเอียดประเภทการเบิกย่อย</small> --}}
    </h3>
@stop

@section('page-title-action')
    <div class="text-right m-t-md">
        <button class="btn btn-primary"
                data-toggle="modal"
                href="#modal-create-form">
            <i class="fa fa-plus"></i> New Rate
        </button>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            <div class="table-resposive">
                <table class="table" id="tableRates">
                    <thead>
                        <tr class="active">
                            <th width="30%">
                                <div>Position</div>
                                <div><small>ตำแหน่ง</small></div>
                            </th>
                            <th width="30%">
                                <div>Location</div>
                                <div><small>พื้นที่</small></div>
                            </th>
                            <th class="text-right">Rate</th>
                            <th class="no-sort" width="15%"></th>
                            <th class="no-sort" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($rates) > 0)
                        @foreach ($rates as $rate)
                            <tr>
                                <td>
                                    {{ $rate->position_po_level ? $positionLists[$rate->position_po_level] : 'Any' }}
                                </td>
                                <td>
                                    {{ $rate->location ? $rate->location->name : 'Any' }}
                                </td>
                                <td class="text-right">
                                    {{ $rate->rate_value ? number_format($rate->rate_value,2) : '0.00' }}
                                </td>
                                <td>
                                    {{ $rate->currency_id }}
                                    @if($policy->type == 'MILEAGE')
                                     / {{ $mileageUnitLists[$policy->mileage_unit] }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="#" id="btn_edit_{{ $rate->policy_rate_id }}" data-rate-id="{{ $rate->policy_rate_id }}" class="btn btn-outline btn-warning btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @if($rate->position_po_level || $rate->location)
                                    <a href="#" id="btn_delete_{{ $rate->policy_rate_id }}" data-rate-id="{{ $rate->policy_rate_id }}" class="btn btn-outline btn-danger btn-xs">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">
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

@include('ie.settings.policies.rates._modal_create')
@include('ie.settings.policies.rates._modal_edit')

@endsection

@section('scripts')
@parent
    <script>
        $(document).ready(function(){

            // EDIT RATE EVENT
            // console.log(nRow, aData, iDisplayIndex, iDisplayIndexFull);
            $("[id^='btn_edit_']").click(function(){
                $("#modal-edit-form").modal('show');
                let id = $(this).attr('data-rate-id');
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/policies/{{ $policy->policy_id }}/rates/"+id+"/edit",
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
                });
            });

            // DELETE RATE EVENT
            // console.log(nRow, aData, iDisplayIndex, iDisplayIndexFull);
            $("[id^='btn_delete_']").click(function(){
                let id = $(this).attr('data-rate-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this rate!",
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
                          url:  "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub-categories/{{ $sub_category->sub_category_id }}/policies/{{ $policy->policy_id }}/rates/"+id+"/inactive",
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

            $(".select2").select2();

            setUnlimitInputRate($("#form-create-rate"));
            bindEventInputUnlimit($("#form-create-rate"));

            function bindEventInputUnlimit(form)
            {
                $(form).find('input[name="unlimit"]').change(function(){
                    setUnlimitInputRate(form);
                });
            }

            function setUnlimitInputRate(form,resetVal)
            {
                // DEFAULT DATA
                resetVal = typeof resetVal !== 'undefined' ? resetVal : true;

                let unlimit = $(form).find('input[name="unlimit"]:checked').val();
                if(unlimit){
                    $(form).find("input[name='rate']").attr('disabled','disabled');
                    $(form).find("input[name='rate']").val('Unlimit');
                }else{
                    $(form).find("input[name='rate']").removeAttr('disabled');
                    if(resetVal){
                        $(form).find("input[name='rate']").val('');
                    }
                }
            }

        });
    </script>
@endsection