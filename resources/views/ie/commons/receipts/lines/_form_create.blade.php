{!! Form::open(['route' => ['receipts.lines.store',$receipt->id], 
                    'method' => 'POST',
                    'id' => 'form-create-receipt-line',
                    'class' => 'form-horizontal']) !!}
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="m-b-sm">
                <div><label for="">
                    <div>Category <span class="text-danger">*</span></div>
                    <div><small>ประเภท</small></div>
                </label></div>
                {!! Form::select('category_id', [''=>'-'] + $categoryLists, null,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_category_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="m-b-sm">
                <div><label for="">
                    <div>Sub-Category <span class="text-danger">*</span></div>
                    <div><small>ประเภทย่อย</small></div>
                </label></div>
                <div id="div_ddl_receipt_line_sub_category_id">
                    {!! Form::select('sub_category_id', [''=>'-'] + $subCategoryLists , null,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_sub_category_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">

        {{-- FORM INFORMATIONS --}}
        <div id="div_form_informations">
            
        </div>

        {{-- FORM AMOUNT --}}
        <div id="div_form_amount">
            
        </div>
    
    </div>

    <div class="hr-line-dashed m-t-sm m-b-sm"></div>

    <div class="text-right">
        <button id="btn_submit_create_receipt_line" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ..." type="button" class="btn btn-primary">
            Save
        </button>
        <button type="button" id="btn_cancel_create_receipt_line" class="btn btn-white" data-dismiss="modal">Cancel</button>
    </div>

{!! Form::close() !!}

<script type="text/javascript">
    
    $(document).ready(function(){

        var formId = "#form-create-receipt-line";
        var receiptId = "{{ $receipt->id }}";

        $(formId).find("select[name='category_id']").select2();
        bindEventSubCategory();
        
        $(formId).find("select[name='category_id']").change(function(){
            var categoryId = $(formId).find("select[name='category_id'] option:selected").val();
            getSubCategories(categoryId);
            $(formId).find("#div_form_informations").html('');
            $(formId).find("#div_form_amount").html('');
        });

        function bindEventSubCategory()
        {
            $(formId).find("select[name='sub_category_id']").select2();
            $(formId).find("select[name='sub_category_id']").change(function(){
            var subCategoryId = $(formId).find("select[name='sub_category_id'] option:selected").val();
                getFormInformations(subCategoryId);
                getFormAmount(subCategoryId);
            });
        }

        function getSubCategories(categoryId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/get_sub_categories/",
                type: 'GET',
                data: {category_id: categoryId},
                beforeSend: function( xhr ) {
                    $("#progress_modal_create").removeClass('hide');
                    $(formId).find("select[name='sub_category_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $("#div_ddl_receipt_line_sub_category_id").html(result);
                $("#progress_modal_create").addClass('hide');
                bindEventSubCategory();
            });
        }

        function getFormInformations(subCategoryId)
        {
            if(subCategoryId){
                $.ajax({
                    url: "{{ url('/') }}/receipts/"+receiptId+"/lines/sub_category/"+subCategoryId+"/get_form_informations",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#progress_modal_create").removeClass('hide');
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_form_informations").html(result);
                    $(formId).find(".select2").select2();
                    $("#progress_modal_create").addClass('hide');
                });
            }else{
                $(formId).find("#div_form_informations").html('');
            }
        }

        function getFormAmount(subCategoryId)
        {
            if(subCategoryId){
                $.ajax({
                    url: "{{ url('/') }}/receipts/"+receiptId+"/lines/sub_category/"+subCategoryId+"/get_form_amount",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#progress_modal_create").removeClass('hide');
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_form_amount").html(result);
                    $("#progress_modal_create").addClass('hide');
                });
            }else{
                $(formId).find("#div_form_amount").html('');
            }
        }

        $( document ).ajaxStart(function() {
            disableForm();
        });

        $( document ).ajaxStop(function() {
            enableForm();
        });

        function disableForm(){
            $(formId).find("select[name='category_id']").attr('disabled','disabled');
            $(formId).find("select[name='sub_category_id']").attr('disabled','disabled');
            $("#btn_submit_create_receipt_line").attr('disabled','disabled');
            $("#btn_cancel_create_receipt_line").attr('disabled','disabled');
        }

        function enableForm(){
            $(formId).find("select[name='category_id']").removeAttr('disabled');
            $(formId).find("select[name='sub_category_id']").removeAttr('disabled');
            $("#btn_submit_create_receipt_line").removeAttr('disabled');
            $("#btn_cancel_create_receipt_line").removeAttr('disabled');
        }

    });

</script>
