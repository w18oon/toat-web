<script type="text/javascript">
    $(document).ready(function(){

        var receiptType = "{{ $receiptType }}";
        var receiptParentId = "{{ $receiptParentId }}";
        var parentCurrencyId = "{{ $parentCurrencyId }}";
        {{-- // var whtCategoryId = "{{ $whtCategoryId }}"; --}}
        {{-- // var whtSubCategoryId = "{{ $whtSubCategoryId }}"; --}}

        bindFormCreateReceiptEvent();
        bindEventReceiptRows();

    /////////////////////////////////////////////////////////////
    ////////////////// RECEIPT HEADER SCRIPT ////////////////////

        //////////////////////////
        //// RENDER ALL RECEIPTS
        function renderReceiptRows(){

            $.ajax({
                url: "{{ url('/') }}/receipts/get_rows",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                        // parent_id = cash_advance_id or reimbursement_id
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#table_receipts tbody").html(result);
                bindEventReceiptRows();
                refreshTableTotalRows();
                refreshTotalAmount(receiptType);
                if(receiptType == 'CLEARING'){
                    refreshDiffCAAndClearingAmount();
                }
            });
        }

        /////////////////////////////
        // Refresh  TOTAL MOUNT
        function refreshTableTotalRows()
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/get_table_total_rows",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                        // parent_id = cash_advance_id or reimbursement_id
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#table_receipts_total_rows tbody").html(result);
            });
        }

        /////////////////////////////
        // REFRESH REIM AMOUNT
        function refreshTotalAmount(receiptType)
        {
            let url = '';
            if(receiptType == 'REIMBURSEMENT'){
                url = "{{ url('/') }}/reimbursements/"+receiptParentId+"/get_total_amount";
            }else if(receiptType == 'CLEARING'){
                url = "{{ url('/') }}/cash-advances/"+receiptParentId+"/get_total_amount";
            }else if(receiptType == 'INVOICE'){
                url = "{{ url('/') }}/invoices/"+receiptParentId+"/get_total_amount";
            }
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#receipt_grand_total_amount,#receipt_grand_total_amount_compare").html(result);
            });
        }

        //////////////////////////////////////
        // REFRESH DIFF CA & CLEARING AMOUNT
        function refreshDiffCAAndClearingAmount()
        {
            $.ajax({
                url: "{{ url('/') }}/cash-advances/"+receiptParentId+"/get_diff_ca_and_clearing_amount",
                type: 'GET',
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#div_diff_ca_and_clearing_amount").html(result);
            });
        }

        ///////////////////////////////////
        //// BIND EVENT TABLE RECEIPT ROWS
        function bindEventReceiptRows(){

            $("#table_receipts .receipt-collapse-row").click(function(e){
                let icon = $(this).find("i");
                let receipt = $(this).attr('data-receipt');
                let tr = $("tr#tr_"+receipt);
                if (tr.is(':visible')) {
                    tr.addClass('animated fadeOutUp')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeOutUp').hide();
                    });
                    icon.removeClass('fa-caret-down');
                    icon.addClass('fa-caret-right');
                } else {
                    tr.show().addClass('animated fadeInDown')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeInDown');
                    });
                    icon.removeClass('fa-caret-right');
                    icon.addClass('fa-caret-down');
                }
                e.preventDefault();
            });

            // EDIT RECEIPT EVENT
            $("[id^='btn_edit_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                $("#modal_edit_receipt").modal('show');
                renderFormEditReceipt(receiptId);
            });

            // DUPLICATE RECEIPT EVENT
            $("[id^='btn_duplicate_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                swal({
                    html: true,
                    title: 'Duplicate receipt ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to duplicate this receipt ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, duplicate it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-info',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitDuplicateReceipt(receiptId);
                    }
                });
                event.preventDefault();
            });

            // REMOVE RECEIPT EVENT
            $("[id^='btn_remove_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                swal({
                    html: true,
                    title: 'Remove receipt ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this receipt ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceipt(receiptId);
                    }
                });
                event.preventDefault();
            });

            // EVENT ADD RECEIPT LINE
            $("[id^='btn_add_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                $("#modal_create_receipt_line").modal('show');
                renderFormCreateReceiptLine(receiptId);
            });

            // EVENT SHOW RECEIPT LINE INFORMATIONS
            $("[id^='button_show_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                $("#modal_show_receipt_line").modal('show');
                renderShowReceiptLineInformations(receiptId,receiptLineId);
            });

            // EVENT EDIT RECEIPT LINE
            $("[id^='button_edit_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                $("#modal_edit_receipt_line").modal('show');
                renderFormEditReceiptLine(receiptId,receiptLineId);
            });

            // EVENT DUPLICATE RECEIPT LINE
            $("[id^='button_duplicate_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                swal({
                    html: true,
                    title: 'Duplicate receipt line ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to duplicate this receipt line ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, duplicate it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-info',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitDuplicateReceiptLine(receiptId,receiptLineId);
                    }
                });
                event.preventDefault();
            });

            // EVENT REMOVE RECEIPT LINE
            $("[id^='button_remove_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                swal({
                    html: true,
                    title: 'Remove receipt line ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this receipt line ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceiptLine(receiptId,receiptLineId);
                    }
                });
                event.preventDefault();
            });
        }

        ////////////////////////////////
        //// RENDER FORM CREATE RECEIPT
        function renderFormCreateReceipt(){

            $.ajax({
                url: "{{ url('/') }}/receipts/form_create",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_create_receipt").html('\
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
                $("#modal_content_create_receipt").html(result);
                bindFormCreateReceiptEvent();
            });

        }

        ////////////////////////////////
        //// RENDER FORM EDIT RECEIPT
        function renderFormEditReceipt(receiptId){

            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/form_edit",
                type: 'GET',
                data: { receipt_id : receiptId,
                        receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_edit_receipt").html('\
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
                $("#modal_content_edit_receipt").html(result);
                bindFormEditReceiptEvent(receiptId);
            });

        }

        ////////////////////////////////////////
        //// BIND EVENT TO FORM CREATE RECEIPT
        function bindFormCreateReceiptEvent(){

            showOracleVendorDetail("#form-create-receipt");
            showOtherVendorForm("#form-create-receipt");
            $('#form-create-receipt select[name="vendor_id"').change(function(e){
                showOracleVendorDetail("#form-create-receipt");
                showOtherVendorForm("#form-create-receipt");
            });

            $("#form-create-receipt").find(".select2").select2();

            /// BTN SUBMIT CREATE
            $("#btn_submit_create_receipt").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitReceipt('create');
                if(valid){
                    $(this).button('loading');
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        // $("#form-create-receipt").submit();
                        submitFormCreateReceipt();
                    }
                }
            });

            ////////////////////////////////////////////
            //// SUBMIT ADD RECEIPT WITH ATTACHMENT (DROPZONE)
            var token = "{{ Session::getToken() }}";
            var myDropzone = new Dropzone("div#dropzoneReceiptAttachment", {
                previewTemplate: $('#template-container').html(),
                url: "{{ url('/') }}/receipts/store",
                params: {
                   _token: token
                },
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 2,
                maxFilesize: 5, // MB
                acceptedFiles: '.jpg, .jpeg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .7z, .txt',
                // Dropzone settings
                init: function() {
                    var myDropzone = this;
                    this.on("maxfilesexceeded", function(file) {
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(file.name + ' upload failed.');
                    });
                    this.on('error', function(file, response) {
                        this.removeFile(file);
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(response);
                    });
                    this.on('queuecomplete', function(){
                        $("#btn_submit_create_receipt").button('reset');
                        renderFormCreateReceipt();
                        renderReceiptRows();
                        $("#modal_create_receipt").modal('hide');
                    });
                }
            });
            myDropzone.on('sending', function(file, xhr, formData){

                formData.append('receipt_type', $("input[name='receipt_type']").val());
                formData.append('receipt_parent_id', $("input[name='receipt_parent_id']").val());
                formData.append('receipt_number', $("input[name='receipt_number']").val());
                formData.append('receipt_date', $("input[name='receipt_date']").val());
                formData.append('location_id', $("select[name='location_id'] option:selected").val());
                formData.append('currency_id', $("select[name='currency_id'] option:selected").val());
                formData.append('exchange_rate', $("input[name='exchange_rate']").val());
                if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){
                    formData.append('establishment_id', $("select[name='establishment_id'] option:selected").val());
                    formData.append('vendor_id', $("select[name='vendor_id'] option:selected").val());
                    formData.append('vendor_name', $("input[name='vendor_name']").val());
                    formData.append('vendor_tax_id', $("input[name='vendor_tax_id']").val());
                    formData.append('vendor_branch_name', $("input[name='vendor_branch_name']").val());
                }
                formData.append('jusification', $("textArea[name='jusification']").val());
                formData.append('project', $("select[name='project']  option:selected").val());
                formData.append('job', $("input[name='job']").val());
                formData.append('recharge', $("select[name='recharge'] option:selected").val());

            });
            myDropzone.on("success", function(file, result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    if(result.receiptId){
                        receiptId = result.receiptId;
                        // AUTO SHOW RECEIPT LINE CREATE FORM
                        $("#modal_create_receipt_line").modal('show');
                        renderFormCreateReceiptLine(receiptId);
                    }
                }
            });

            $('#form-create-receipt #txt_receipt_date').datepicker({
                format: "{{ trans('date.js-format') }}",
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT CREATE RECEIPT WITH OUT ATTACHMENT
        function submitFormCreateReceipt(){
            var formData = $('#form-create-receipt').serialize();
            $.ajax({
                url: "{{ url('/') }}/receipts/store",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    receiptId = result.receiptId;
                    // AUTO SHOW RECEIPT LINE CREATE FORM
                    $("#modal_create_receipt_line").modal('show');
                    renderFormCreateReceiptLine(receiptId);
                    // RENDOR RECEIPT TABLE ROWS
                    renderReceiptRows();
                }
                renderFormCreateReceipt();
                $("#modal_create_receipt").modal('hide');
            });
        }

        ////////////////////////////////////////
        //// BIND EVENT TO FORM EDIT RECEIPT
        function bindFormEditReceiptEvent(receiptId){

            showOracleVendorDetail("#form-edit-receipt");
            showOtherVendorForm("#form-edit-receipt");
            $('#form-edit-receipt select[name="vendor_id"]').change(function(e){
                showOracleVendorDetail("#form-edit-receipt");
                showOtherVendorForm("#form-edit-receipt");
            });

            $("#form-edit-receipt").find(".select2").select2();

            /// BTN SUBMIT EDIT
            $("#btn_submit_edit_receipt").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitReceipt('edit');
                if(valid){
                    $(this).button('loading');
                    submitFormEditReceipt(receiptId);
                }
            });

            // ADD ATTACHMENT
            $("#inputReceiptAttachment").change(function(){
                if(this.value){
                    let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                    $("#receiptAttachmentDescText").text(filename);
                    $("#receiptAttachmentDesc").removeClass("hide");
                    $("#btnAddReceiptFile").addClass("hide");
                }else{
                    $("#receiptAttachmentDescText").text("");
                    $("#receiptAttachmentDesc").addClass("hide");
                    $("#btnAddReceiptFile").removeClass("hide");
                }
            });

            // UPLOAD ATTACHMENT
            $("#btnUploadReceiptFile").click(function(){
                $("#form-add-receipt-attachment").submit();
            });

            // CANCEL ATTACHMENT
            $("#btnCancelReceiptFile").click(function(){
                $("#inputReceiptAttachment").val('');
                $("#receiptAttachmentDescText").text("");
                $("#receiptAttachmentDesc").addClass("hide");
                $("#btnAddReceiptFile").removeClass("hide");
            });

            ////////////////////////////////////////////
            //// SUBMIT ADD RECEIPT ATTACHMENT
            $("#form-add-receipt-attachment").submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);
                var receiptId = $(this).find("input[name='receipt_id']").val();
                $.ajax({
                    url: "{{ url('/') }}/receipts/"+receiptId+"/add_attachment",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    beforeSend: function(){
                        $("#btnUploadReceiptFile").button('loading');
                        $("#btnCancelReceiptFile").attr('disabled','disabled');
                    }
                })
                .done(function(result) {
                    if(result.toUpperCase() != 'SUCCESS'){
                        swal({
                          title: "Error !",
                          text: "sorry something went wrong.",
                          type: "error",
                          // timer: 2000,
                          showConfirmButton: true
                        });
                    }else{
                        renderReceiptRows();
                    }
                    renderFormEditReceipt(receiptId);
                });
                return false;
            });

            // BTN REMOVE ATTACHMENT
            $("[id^='btn_remove_receipt_attachment_']").click(function(e) {
                var receiptId = $(this).attr('data-receipt-id');
                var attachmentId = $(this).attr('data-attachment-id');
                swal({
                    html: true,
                    title: 'Remove attachment ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this attachment ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceiptAttachment(receiptId,attachmentId);
                    }
                });
                event.preventDefault();
            });

            $('#form-edit-receipt #txt_receipt_date').datepicker({
                format: "{{ trans('date.js-format') }}",
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT EDIT RECEIPT WITH OUT ATTACHMENT
        function submitFormEditReceipt(receiptId)
        {
            var formData = $('#form-edit-receipt').serialize();
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/update",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                // renderFormEditReceipt(receiptId);
                $("#modal_edit_receipt").modal('hide');
            });
        }

        ///////////////////////////////////
        //// SUBMIT DUPLICATE RECEIPT
        function submitDuplicateReceipt(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/duplicate",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}",
                        receipt_parent_id: receiptParentId,
                        receipt_type: receiptType },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ///////////////////////////////////
        //// SUBMIT REMOVE RECEIPT
        function submitRemoveReceipt(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT REMOVE RECEIPT ATTACHMENT
        function submitRemoveReceiptAttachment(receiptId,attachmentId)
        {
            $.ajax({
                url: "{{ url('/') }}/attachments/"+attachmentId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
                renderFormEditReceipt(receiptId);
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT DUPLICATE RECEIPT LINE
        function submitDuplicateReceiptLine(receiptId,receiptLineId){
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/duplicate",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT REMOVE RECEIPT LINE
        function submitRemoveReceiptLine(receiptId,receiptLineId){
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        //////////////////////////////////
        //// VALIDATE BEFORE SUBMIT RECEIPT
        function validateBeforeSubmitReceipt(formType)
        {
            if(formType == 'create'){
                var formId = "#form-create-receipt";
            }else{
                var formId = "#form-edit-receipt";
            }

            $(formId).find("input[name='receipt_number']").next("div.error_msg").remove();
            $(formId).find("input[name='receipt_date']").next("div.error_msg").remove();
            if(formType == 'create'){
                $(formId).find("#select2-ddl_location_id-container").parent().next("div.error_msg").remove();
                $(formId).find("select[name='currency_id']").next("div.error_msg").remove();
                $(formId).find("input[name='exchange_rate']").next("div.error_msg").remove();
            }
            $(formId).find("select[name='establishment_id']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_vendor_id-container").parent().next("div.error_msg").remove();
            $(formId).find("input[name='vendor_name']").next("div.error_msg").remove();
            $(formId).find("input[name='vendor_tax_id']").next("div.error_msg").remove();
            $(formId).find("input[name='vendor_branch_name']").next("div.error_msg").remove();
            $(formId).find("textArea[name='jusification']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_project-container").parent().next("div.error_msg").remove();
            $(formId).find("input[name='job']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_recharge-container").parent().next("div.error_msg").remove();

            $(formId).find("input[name='receipt_number']").removeClass('err_validate');
            $(formId).find("input[name='receipt_date']").removeClass('err_validate');
            if(formType == 'create'){
                $(formId).find("select[name='currency_id']").removeClass('err_validate');
                $(formId).find("input[name='exchange_rate']").removeClass('err_validate');
            }
            $(formId).find("select[name='establishment_id']").removeClass('err_validate');
            $(formId).find("input[name='vendor_name']").removeClass('err_validate');
            $(formId).find("input[name='vendor_tax_id']").removeClass('err_validate');
            $(formId).find("input[name='vendor_branch_name']").removeClass('err_validate');
            $(formId).find("textArea[name='jusification']").removeClass('err_validate');
            $(formId).find("input[name='job']").removeClass('err_validate');

            var valid = true;
            var receipt_number = $(formId).find("input[name='receipt_number']").val();
            var receipt_date = $(formId).find("input[name='receipt_date']").val();
            if(formType == 'create'){
                var location_id = $(formId).find("select[name='location_id'] option:selected").val();
                var currency_id = $(formId).find("select[name='currency_id'] option:selected").val();
                var exchange_rate = $(formId).find("input[name='exchange_rate']").val();
            }
            var establishment_id = $(formId).find("select[name='establishment_id'] option:selected").val();
            var vendor_id = $(formId).find("select[name='vendor_id'] option:selected").val();
            var vendor_name = $(formId).find("input[name='vendor_name']").val();
            var vendor_tax_id = $(formId).find("input[name='vendor_tax_id']").val();
            var vendor_branch_name = $(formId).find("input[name='vendor_branch_name']").val();
            var jusification = $(formId).find("textArea[name='jusification']").val();
            var project = $(formId).find("select[name='project']  option:selected").val();
            var job = $(formId).find("input[name='job']").val();
            var recharge = $(formId).find("select[name='recharge'] option:selected").val();

            if(!receipt_number){
                valid = false;
                $(formId).find("input[name='receipt_number']").addClass('err_validate');
                $(formId).find("input[name='receipt_number']").after('<div class="error_msg"> tax invoice/receipt number is required. </div>');
            }
            if(!receipt_date){
                valid = false;
                $(formId).find("input[name='receipt_date']").addClass('err_validate');
                $(formId).find("input[name='receipt_date']").after('<div class="error_msg"> date is required.</div>');
            }
            if(formType == 'create'){
                if(!location_id){
                    valid = false;
                    $(formId).find("#select2-ddl_location_id-container").parent().after('<div class="error_msg"> destination is required. </div>');
                }
                if(currency_id != parentCurrencyId){
                    if(exchange_rate == ''){
                        valid = false;
                        $(formId).find("input[name='exchange_rate']").addClass('err_validate');
                        $(formId).find("input[name='exchange_rate']").after('<div class="error_msg"> exchange rate is required.</div>');
                    }else if(!$.isNumeric(exchange_rate)){
                        valid = false;
                        $(formId).find("input[name='exchange_rate']").addClass('err_validate');
                        $(formId).find("input[name='exchange_rate']").after('<div class="error_msg"> exchange rate must be a number.</div>');
                    }
                }
            }

            // USE ONLY REIMBURSEMENT && CLEARING
            if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){

                if(!establishment_id){
                    valid = false;
                    $(formId).find("select[name='establishment_id']").addClass('err_validate');
                    $(formId).find("select[name='establishment_id']").after('<div class="error_msg"> tmith branch is required.</div>');
                }

                // if(!vendor_id){
                //     valid = false;
                //     $(formId).find("#select2-ddl_vendor_id-container").parent().after('<div class="error_msg"> vendor is required. </div>');
                // }
                if(vendor_id == 'other'){
                    if(!vendor_name){
                        valid = false;
                        $(formId).find("input[name='vendor_name']").addClass('err_validate');
                        $(formId).find("input[name='vendor_name']").after('<div class="error_msg"> vendor name is required.</div>');
                    }
                    if(!vendor_tax_id){
                        valid = false;
                        $(formId).find("input[name='vendor_tax_id']").addClass('err_validate');
                        $(formId).find("input[name='vendor_tax_id']").after('<div class="error_msg"> tax id is required.</div>');
                    }else{
                        if(vendor_tax_id.length != 13){
                            valid = false;
                            $(formId).find("input[name='vendor_tax_id']").addClass('err_validate');
                            $(formId).find("input[name='vendor_tax_id']").after('<div class="error_msg"> tax id must be 13 digits.</div>');
                        }
                    }

                    if(!vendor_branch_name){
                        // valid = false;
                        // $(formId).find("input[name='vendor_branch_name']").addClass('err_validate');
                        // $(formId).find("input[name='vendor_branch_name']").after('<div class="error_msg"> branch number is required.</div>');
                    }else{
                        if(vendor_branch_name.length > 5){
                            valid = false;
                            $(formId).find("input[name='vendor_branch_name']").addClass('err_validate');
                            $(formId).find("input[name='vendor_branch_name']").after('<div class="error_msg"> branch number maximum is 5 digits.</div>');
                        }
                    }
                }
            }

            if(!jusification){
                valid = false;
                $(formId).find("textArea[name='jusification']").addClass('err_validate');
                $(formId).find("textArea[name='jusification']").after('<div class="error_msg"> description is required.</div>');
            }
            if(!project){
                valid = false;
                $(formId).find("#select2-ddl_project-container").parent().after('<div class="error_msg"> project is required.</div>');
            }
            if(!job){
                valid = false;
                $(formId).find("input[name='job']").addClass('err_validate');
                $(formId).find("input[name='job']").after('<div class="error_msg"> job is required.</div>');
            }
            if(!recharge){
                valid = false;
                $(formId).find("#select2-ddl_recharge-container").parent().after('<div class="error_msg"> recharge is required.</div>');
            }

            return valid;
        }

        function showOracleVendorDetail(formId)
        {
            // USE ONLY REIMBURSEMENT && CLEARING
            if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){

                var selectValue =  $(formId).find('select[name="vendor_id"] option:selected');
                var divOracleVendorDetail = $(formId).find('#div_oracle_vendor_detail');

                if (selectValue.val() != '' && selectValue.val() != 'other') {
                    divOracleVendorDetail.fadeIn('slow');
                    $.ajax({
                        url: "{{ url('/') }}/receipts/get_vendor_detail/"+selectValue.val(),
                        type: 'GET',
                        beforeSend: function( xhr ) {
                            //
                        }
                    })
                    .done(function(result) {
                        divOracleVendorDetail.html(result);
                    });

                } else {
                    divOracleVendorDetail.fadeOut('slow');
                    divOracleVendorDetail.html('');
                }

            }
        }

        function showOtherVendorForm(formId) {
            var selectValue =  $(formId).find('select[name="vendor_id"] option:selected');
            var tagShowOtherVendor = $(formId).find('#showOtherVendor');

            if (selectValue.val() == 'other') {
                tagShowOtherVendor.fadeIn('slow')
            } else {
                tagShowOtherVendor.fadeOut('slow');
            }
        }

    ///////////////////////////////////////////////////////////
    ////////////////// RECEIPT LINE SCRIPT ////////////////////

        /////////////////////////////////////
        //// RENDER FORM CREATE RECEIPT LINE
        function renderFormCreateReceiptLine(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/form_create",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_create_receipt_line").html('\
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
                $("#modal_content_create_receipt_line").html(result);
                bindFormCreateReceiptLineEvent(receiptId);
            });
        }

        /////////////////////////////////////
        //// RENDER FORM EDIT RECEIPT LINE
        function renderFormEditReceiptLine(receiptId, receiptLineId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/form_edit",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_edit_receipt_line").html('\
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
                $("#modal_content_edit_receipt_line").html(result);
                bindFormEditReceiptLineEvent(receiptId, receiptLineId);
            });
        }

        function renderShowReceiptLineInformations(receiptId, receiptLineId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/get_show_infos",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_show_receipt_line").html('\
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
                $("#modal_content_show_receipt_line").html(result);
            });
        }

        function bindFormCreateReceiptLineEvent(receiptId)
        {
            /// BTN SUBMIT CREATE
            $("#btn_submit_create_receipt_line").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitCreateReceiptLine(receiptId);
                if(valid){
                    $(this).button('loading');
                    submitFormCreateReceiptLine(receiptId);
                }
            });
        }

        function bindFormEditReceiptLineEvent(receiptId, receiptLineId)
        {
            /// BTN SUBMIT EDIT
            $("#btn_submit_edit_receipt_line").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitEditReceiptLine(receiptId);
                if(valid){
                    $(this).button('loading');
                    submitFormEditReceiptLine(receiptId, receiptLineId);
                }
            });
        }

        function validateBeforeSubmitCreateReceiptLine(receiptId)
        {
            var formId = "#form-create-receipt-line";

            $(formId).find("select[name='category_id']").parent().next("div.error_msg").remove();
            $(formId).find("select[name='category_id']").removeClass('err_validate');
            $(formId).find("select[name='sub_category_id']").parent().next("div.error_msg").remove();
            $(formId).find("select[name='sub_category_id']").removeClass('err_validate');

            // $(formId).find("input[name='amount']").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='amount']").removeClass('err_validate');
            // $(formId).find("input[name='amount_inc_vat']").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='amount_inc_vat']").removeClass('err_validate');

            $(formId).find("#div_alert_form_amount").addClass("hide");
            $(formId).find("#ul_alert_form_amount").html('');

            var valid = true; var arr_err_amount = [];
            var category_id = $(formId).find("select[name='category_id'] option:selected").val();
            var sub_category_id = $(formId).find("select[name='sub_category_id'] option:selected").val();
            var quantity = $(formId).find("input[name='quantity']").val();
            var second_quantity = $(formId).find("input[name='second_quantity']").val();
            var amount = $(formId).find("input[name='amount']").val();
            var amount_inc_vat = $(formId).find("input[name='amount_inc_vat']").val();
            var primary_amount = $(formId).find("input[name='primary_amount']").val();
            var primary_vat_amount = $(formId).find("input[name='primary_vat_amount']").val();
            var primary_amount_inc_vat = $(formId).find("input[name='primary_amount_inc_vat']").val();

            if(!category_id){
                valid = false;
                $(formId).find("select[name='category_id']").addClass('err_validate');
                $(formId).find("select[name='category_id']").parent().after('<div class="error_msg"> category is required. </div>');
            }

            if(!sub_category_id){
                valid = false;
                $(formId).find("select[name='sub_category_id']").addClass('err_validate');
                $(formId).find("select[name='sub_category_id']").parent().after('<div class="error_msg"> sub-category is required. </div>');
            }

            if(quantity == ''){
                valid = false;
                arr_err_amount.push("quantity is required.");
            }else if(!$.isNumeric(quantity)){
                valid = false;
                arr_err_amount.push("quantity must be a number.");
            }
            if(second_quantity == ''){
                valid = false;
                arr_err_amount.push("second quantity is required.");
            }else if(!$.isNumeric(second_quantity)){
                valid = false;
                arr_err_amount.push("second quantity must be a number.");
            }
            if(amount == ''){
                valid = false;
                arr_err_amount.push("amount before vat is required.");
            }else if(!$.isNumeric(amount)){
                valid = false;
                arr_err_amount.push("amount before vat must be a number.");
            }else{
                // // VALIDATE WHT
                // if(whtSubCategoryId == sub_category_id){
                //     if(parseFloat(amount) > 0 ){
                //         valid = false;
                //         arr_err_amount.push("wht amount must be negative value.");
                //     }
                // }
            }

            if(amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("amount inc. vat is required.");
            }else if(!$.isNumeric(amount_inc_vat)){
                valid = false;
                arr_err_amount.push("amount inc. vat must be a number.");
            }

            if(primary_amount == ''){
                valid = false;
                arr_err_amount.push("base amount is required.");
            }else if(!$.isNumeric(primary_amount)){
                valid = false;
                arr_err_amount.push("base amount must be a number.");
            }

            if(primary_vat_amount == ''){
                valid = false;
                arr_err_amount.push("base vat amount is required.");
            }else if(!$.isNumeric(primary_vat_amount)){
                valid = false;
                arr_err_amount.push("base vat amount must be a number.");
            }

            if(primary_amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("base amount inc vat is required.");
            }else if(!$.isNumeric(primary_amount_inc_vat)){
                valid = false;
                arr_err_amount.push("base amount inc vat must be a number.");
            }

            if(arr_err_amount.length > 0){
                $(formId).find("#div_alert_form_amount").removeClass("hide");
                for (index in arr_err_amount) {
                    let li = '<li>'+arr_err_amount[index]+'</li>';
                    $(formId).find("#ul_alert_form_amount").append(li);
                }
            }

            var validInfos = validateReceiptLineInformations(formId,receiptId);
            if(valid){ valid = validInfos; }

            return valid;
        }

        function validateBeforeSubmitEditReceiptLine(receiptId)
        {
            var formId = "#form-edit-receipt-line";

            $(formId).find("#div_alert_form_amount").addClass("hide");
            $(formId).find("#ul_alert_form_amount").html('');

            var valid = true; var arr_err_amount = [];

            var quantity = $(formId).find("input[name='quantity']").val();
            var second_quantity = $(formId).find("input[name='second_quantity']").val();
            var amount = $(formId).find("input[name='amount']").val();
            var amount_inc_vat = $(formId).find("input[name='amount_inc_vat']").val();
            var primary_amount = $(formId).find("input[name='primary_amount']").val();
            var primary_vat_amount = $(formId).find("input[name='primary_vat_amount']").val();
            var primary_amount_inc_vat = $(formId).find("input[name='primary_amount_inc_vat']").val();
            var sub_category_id = $(formId).find("input[name='sub_category_id']").val();

            if(quantity == ''){
                valid = false;
                arr_err_amount.push("quantity is required.");
            }else if(!$.isNumeric(quantity)){
                valid = false;
                arr_err_amount.push("quantity must be a number.");
            }
            if(second_quantity == ''){
                valid = false;
                arr_err_amount.push("second quantity is required.");
            }else if(!$.isNumeric(second_quantity)){
                valid = false;
                arr_err_amount.push("second quantity must be a number.");
            }
            if(amount == ''){
                valid = false;
                arr_err_amount.push("amount before vat is required.");
            }else if(!$.isNumeric(amount)){
                valid = false;
                arr_err_amount.push("amount before vat must be a number.");
            }else{
                // // VALIDATE WHT
                // if(whtSubCategoryId == sub_category_id){
                //     if(parseFloat(amount) > 0 ){
                //         valid = false;
                //         arr_err_amount.push("wht amount must be negative value.");
                //     }
                // }
            }

            if(amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("amount inc. vat is required.");
            }else if(!$.isNumeric(amount_inc_vat)){
                valid = false;
                arr_err_amount.push("amount inc. vat must be a number.");
            }

            if(primary_amount == ''){
                valid = false;
                arr_err_amount.push("base amount is required.");
            }else if(!$.isNumeric(primary_amount)){
                valid = false;
                arr_err_amount.push("base amount must be a number.");
            }

            if(primary_vat_amount == ''){
                valid = false;
                arr_err_amount.push("base vat amount is required.");
            }else if(!$.isNumeric(primary_vat_amount)){
                valid = false;
                arr_err_amount.push("base vat amount must be a number.");
            }

            if(primary_amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("base amount inc vat is required.");
            }else if(!$.isNumeric(primary_amount_inc_vat)){
                valid = false;
                arr_err_amount.push("base amount inc vat must be a number.");
            }

            if(arr_err_amount.length > 0){
                $(formId).find("#div_alert_form_amount").removeClass("hide");
                for (index in arr_err_amount) {
                    let li = '<li>'+arr_err_amount[index]+'</li>';
                    $(formId).find("#ul_alert_form_amount").append(li);
                }
            }
            var validInfos = validateReceiptLineInformations(formId,receiptId);
            if(valid){ valid = validInfos; }

            return valid;
        }

        function validateReceiptLineInformations(formId, receiptId)
        {
            var validInfos = true;

            $(formId).find("[id^='ip_sub_category_infos_']").each(function(index, element) {

                $(element).removeClass('err_validate');
                $(element).next("div.error_msg").remove();

                var value = $(element).val();
                var required = $(element).attr('data-required');
                var label = $(element).attr('data-label');
                if(required == 'required' && !value){
                    validInfos = false;
                    $(element).addClass('err_validate');
                    $(element).after('<div class="error_msg"> '+label+' is required. </div>');
                }

            });

            return validInfos;
        }

        function submitFormCreateReceiptLine(receiptId)
        {
            var formData = $('#form-create-receipt-line').serialize();
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/store",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    var errMsg = result.err_msg;
                    if(!errMsg){
                        errMsg = "sorry something went wrong.";
                    }
                    swal({
                      title: "Error !",
                      text: errMsg,
                      type: "error",
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                renderFormCreateReceiptLine(receiptId);
                $("#modal_create_receipt_line").modal('hide');
            });
        }

        function submitFormEditReceiptLine(receiptId, receiptLineId)
        {
            var formData = $('#form-edit-receipt-line').serialize();
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/update",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    var errMsg = result.err_msg;
                    if(!errMsg){
                        errMsg = "sorry something went wrong.";
                    }
                    swal({
                      title: "Error !",
                      text: errMsg,
                      type: "error",
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                $("#modal_content_edit_receipt_line").html('');
                $("#modal_edit_receipt_line").modal('hide');
            });
        }

    });
</script>