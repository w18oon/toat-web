@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        <div>Reimbursement : New Request</div>
        <div><small>สร้างใบเบิกเงินชดเชยใหม่</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.reimbursements.index') }}">
                Reimbursement
            </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
               New Request
            </strong>
        </li>
    </ol>
@stop

@section('content')
@include('layouts._warning_create_request')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                <strong>Request Form</strong>
                <span class="pull-right">
                    <p>Request Date : {{ date(trans('date.format')) }}</p>
                </span>
                </div>
            </div>
            <hr class="m-t-sm mm-b-sm">
            {{-- FORM REIMBURSEMENT --}}
            {!! Form::open(['route' => ['ie.reimbursements.store'], 'id' => 'form-reimbursement','class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-8 b-r">

                    {{-- FORM REIMBURSEMENT HTML --}}
                    @include('ie.reimbursements._form')

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Attachments (ไฟล์แนบ)</label>
                            {{-- <div class="text-center dropzone m-t-xs m-b-xs" id="dropzoneFileUpload">
                                <div class="dz-message p-lg">
                                    <div>
                                        <i class="fa fa-file-text-o fa-3x"></i>
                                    </div>
                                    <div class="m-t-md">Drop files or Click</div>
                                </div>
                            </div> --}}
                            <small style="color:#aaa"> Allow: jpeg, png, pdf, doc, docx, xls, xlsx, rar, zip and size < 5mb </small><br>
                            <small style="color:#aaa"> Max files : 2</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            @include('ie.commons._unclear_alert_message')
                        </div>
                    </div>
                    @include('layouts._dropzone_template')
                </div>
            </div>
            <hr class="m-t-xs m-b-sm">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10 ">
                            {{-- @if(\Auth::user()->isAllowCreateRequest()) --}}
                            @if(true)
                                <button id="btn_submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Creating ..." type="button" class="btn btn-primary">
                                    Create
                                </button>
                            @endif
                            <a href="{{ route('ie.reimbursements.index') }}" class="btn btn-white">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close()!!}
            {{-- FORM --}}
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script>

        $(document).ready(function() {

            $("#btn_submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmit();
                if(valid){
                    $("#form-reimbursement").submit();
                    $(this).button('loading');
                    // if (myDropzone.getQueuedFiles().length > 0) {
                    //     myDropzone.processQueue();
                    // } else {
                    //     $("#form-reimbursement").submit();
                    // }
                }
            });

            // ==== DROPZONE ====
            // var token = "{{ csrf_token() }}";
            // var myDropzone = new Dropzone("div#dropzoneFileUpload", {
            //     previewTemplate: $('#template-container').html(),
            //     url: "/ie/reimbursements/store",
            //     params: {
            //        _token: token
            //     },
            //     autoProcessQueue: false,
            //     uploadMultiple: true,
            //     maxFiles: 2,
            //     maxFilesize: 5, // MB
            //     acceptedFiles: '.jpg, .jpeg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .7z, .txt',
            //     // Dropzone settings
            //     init: function() {
            //         var myDropzone = this;
            //         this.on("maxfilesexceeded", function(file) {
            //             toastr.options = {
            //                 "timeOut": "3000",
            //             }
            //             toastr.error(file.name + ' upload failed.');
            //         });
            //         this.on('error', function(file, response) {
            //             if(file){ this.removeFile(file); }
            //             toastr.options = {
            //                 "timeOut": "3000",
            //             }
            //             toastr.error(response);
            //         });
            //         this.on('queuecomplete', function(){
            //             $("#btn_submit").button('reset');
            //         });
            //     }
            // });
            // myDropzone.on('sending', function(file, xhr, formData){
            //     // formData.append('position_id', $("input[name='position_id']").val());
            //     formData.append('bank_account_id', $("input[name='bank_account_id']").val());
            //     formData.append('company_id', $("input[name='company_id']").val());
            //     formData.append('department_id', $("input[name='department_id']").val());
            //     formData.append('bank_account_id', $("input[name='bank_account_id']").val());
            //     formData.append('purpose', $("textarea[name='purpose']").val());
            // });
            // myDropzone.on("success", function(file, result) {
            //     if((result.status).toUpperCase() == 'ERROR'){
            //         swal({
            //           title: "Error !",
            //           text: "sorry something went wrong, this page will refresh in 2 seconds.",
            //           type: "error",
            //           timer: 2000,
            //           showConfirmButton: false
            //         },function(){
            //             location.reload();
            //         });
            //     }else{
            //         $("#btn_submit").attr('disabled','disabled');
            //         setTimeout(function(){
            //             window.location.href = ("/ie/reimbursements/"+result.reimId);
            //         }, 1000);
            //     }
            // });

            function validateBeforeSubmit()
            {
                $("textarea[name='purpose']").next("div.error_msg").remove();
                $("textarea[name='purpose']").removeClass('err_validate');

                var valid = true;
                var purpose = $("textarea[name='purpose']").val();

                if(!purpose){
                    valid = false;
                    $("textarea[name='purpose']").addClass('err_validate');
                    $("textarea[name='purpose']").after('<div class="error_msg"> purpose is required.</div>');
                }
                return valid;
            }

        });
    </script>
@stop