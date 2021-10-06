{{-- <div class="row m-b-sm clearfix">
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Category</div>
                <div><small>ประเภท</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ $receiptLine->category->name }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Sub-Category</div>
                <div><small>ประเภทย่อย</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ $receiptLine->subCategory->name }}</p>
            </div>
        </div>
    </div>
</div> --}}

{!! Form::open(['route' => ['receipts.lines.update',$receipt->id,$receiptLine->id],
                    'method' => 'POST',
                    'id' => 'form-edit-receipt-line',
                    'class' => 'form-horizontal']) !!}

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="m-b-sm">
                <div><label for="">
                    <div>Category <span class="text-danger">*</span></div>
                    <div><small>ประเภท</small></div>
                </label></div>
                {!! Form::select('category_id', [''=>'-'] + $categoryLists, $receiptLine->category_id,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_category_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="m-b-sm">
                <div><label for="">
                    <div>Sub-Category <span class="text-danger">*</span></div>
                    <div><small>ประเภทย่อย</small></div>
                </label></div>
                <div id="div_ddl_receipt_line_sub_category_id">
                    {!! Form::select('sub_category_id', [''=>'-'] + $subCategoryLists , $receiptLine->sub_category_id,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_sub_category_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
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
        <button id="btn_submit_edit_receipt_line" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ..." type="button" class="btn btn-primary">
            Save
        </button>
        <button type="button" id="btn_cancel_edit_receipt_line" class="btn btn-white" data-dismiss="modal">Cancel</button>
    </div>

{!! Form::close() !!}

<script type="text/javascript">

    $(document).ready(function(){

        var formId = "#form-edit-receipt-line";
        var receiptId = "{{ $receipt->id }}";
        var receiptLineId = "{{ $receiptLine->id }}";

        getFormInformations(receiptLineId,'edit');
        getFormAmount(receiptLineId,'edit');

        $(formId).find("select[name='category_id']").select2();
        bindEventSubCategory();

        $(formId).find("select[name='category_id']").change(function(){
            var categoryId = $(formId).find("select[name='category_id'] option:selected").val();
            getSubCategories(categoryId);
            $(formId).find("#div_form_informations").html('');
            $(formId).find("#div_form_amount").html('');
        });

        // BIND EVENT TO INPUT SUB-CATEGORIES
        function bindEventSubCategory()
        {
            $(formId).find("select[name='sub_category_id']").select2();
            $(formId).find("select[name='sub_category_id']").change(function(){
            var subCategoryId = $(formId).find("select[name='sub_category_id'] option:selected").val();
                getFormInformations(subCategoryId);
                getFormAmount(subCategoryId);
            });
        }

        // GET INPUT SUB-CATEGORIES BY CATEGORY
        function getSubCategories(categoryId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/get_sub_categories/",
                type: 'GET',
                data: {category_id: categoryId},
                beforeSend: function( xhr ) {
                    $("#progress_modal_edit").removeClass('hide');
                    $(formId).find("select[name='sub_category_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $("#div_ddl_receipt_line_sub_category_id").html(result);
                $("#progress_modal_edit").addClass('hide');
                bindEventSubCategory();
            });
        }

        // GET INFORMATION FORM
        function getFormInformations(subCategoryId,formType)
        {
            formType = typeof formType !== 'undefined' ? formType : 'create';
            var url;
            if(subCategoryId){
                if(formType == 'create'){
                    url = "{{ url('/') }}/receipts/"+receiptId+"/lines/sub_category/"+subCategoryId+"/get_form_informations";
                }else if(formType == 'edit'){
                    url = "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/get_form_edit_informations";
                }
                if(url){
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function( xhr ) {
                            $("#progress_modal_edit").removeClass('hide');
                        }
                    })
                    .done(function(result) {
                        $(formId).find("#div_form_informations").html(result);
                        $(formId).find(".select2").select2();
                        $("#progress_modal_edit").addClass('hide');
                    });
                }
            }else{
                $(formId).find("#div_form_informations").html('');
            }
        }

        // GET NEW AMOUNT FORM
        function getFormAmount(subCategoryId,formType)
        {
            formType = typeof formType !== 'undefined' ? formType : 'create';
            var url;
            if(subCategoryId){
                if(formType == 'create'){
                    url = "{{ url('/') }}/receipts/"+receiptId+"/lines/sub_category/"+subCategoryId+"/get_form_amount";
                }else if(formType == 'edit'){
                    url = "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/get_form_edit_amount";
                }
                if(url){
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {form_id: formId},
                        beforeSend: function( xhr ) {
                            $("#progress_modal_edit").removeClass('hide');
                        }
                    })
                    .done(function(result) {
                        $(formId).find("#div_form_amount").html(result);
                        $("#progress_modal_edit").addClass('hide');
                    });
                }
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
            $("#btn_submit_edit_receipt_line").attr('disabled','disabled');
            $("#btn_cancel_edit_receipt_line").attr('disabled','disabled');
        }

        function enableForm(){
            $("#btn_submit_edit_receipt_line").removeAttr('disabled');
            $("#btn_cancel_edit_receipt_line").removeAttr('disabled');
        }

    });

</script>
