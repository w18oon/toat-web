@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        Reimbursements : My Request <br/>
        <small>รายการใบเบิกเงินชดเชยของคุณ</small>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>
                Reimbursements : My Request
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <a href="{{ route('ie.reimbursements.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Request Reimbursement
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                @include('ie.reimbursements._table')
                @if(isset($reims))
                <div class="m-t-sm text-right">
                    {!! $reims->appends($search)->render() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function() {

            $("[id^='btn_duplicate_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var reimId = $(this).attr("data-id");
                swal({
                    html: true,
                    title: 'Duplicate this reimbursement ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px">Are you sure to duplicate this reimbursement request ?</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    // confirmButtonColor: "#DD6B55",
                    confirmButtonText: " Yes !",
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-info',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "post",
                            url:  "{{ url('/') }}/reimbursements/"+reimId+"/duplicate",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function() {
                                //
                            },
                            success: function (data) {
                                swal({
                                  title: "Duplicate completed !",
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
@stop