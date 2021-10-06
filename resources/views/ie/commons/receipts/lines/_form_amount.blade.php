
<div class="hr-line-dashed m-t-sm m-b-sm"></div>

{{-- ALERT ERROR MESSAGE FORM AMOUNT --}}
<div id="div_alert_form_amount" class="alert alert-warning hide">
    <ul id="ul_alert_form_amount">
    {{-- LIST ALEART MESSAGE FORM AMOUNT --}}
    </ul>
</div>

<div class="tabs-container tab-form-receipt-line-amount">

    <ul class="nav nav-tabs">
    @if($policyExpense)
        <li class="active">
            <a data-toggle="tab" data-policy-id="{{ $policyExpense->id }}" data-rate-id="{{ $rateExpense->id }}" 
                class="tab-policy" href="#tab-expense" data-tab-type="expense"> 
                <div><i class="fa fa-money"></i>Expense</div>
                <div><small>เบิกค่าใช้จ่าย</small></div>
            </a>
        </li>
    @endif
    @if($policyMileage)
        <li class="{{ !$policyExpense ? 'active':'' }}">
            <a data-toggle="tab" data-policy-id="{{ $policyMileage->id }}" data-rate-id="{{ $rateMileage->id }}" 
                class="tab-policy" href="#tab-mileage" data-tab-type="mileage"> 
                <div><i class="fa fa-road"></i>Mileage</div>
                <div><small>เบิกตามระยะทาง</small></div>
            </a>
        </li>
    @endif
    @if(!$policyExpense && !$policyMileage)
        <li class="active">
            <a data-toggle="tab" data-policy-id="" data-rate-id="" 
                class="tab-policy" href="#tab-actual" data-tab-type="actual"> 
                <div><i class="fa fa-check-square-o"></i>Actual</div>
                <div><small>เบิกตามจริง</small></div>
            </a>
        </li>
    @endif
    </ul>
    <div class="tab-content">
    @if($policyExpense)
        {{-- ========================== --}}
        {{-- ==== TAB EXPENSE FORM ==== --}}
        {{-- ========================== --}}
        <div id="tab-expense" class="tab-pane active">
            <div class="panel-body">
                <div class="col-md-3" style="padding-left: 5px;padding-right: 5px;">
                    <div class="m-b-sm">
                        <div><label for="">
                            <div>Quantity <span class="text-danger">*</span></div>
                            <div><small>จำนวน</small></div>
                        </label></div>
                        <div class="input-group">
                            {!! Form::text('expense_quantity', $defaultQuantity, ['class'=>'form-control text-right input-sm','style'=>'padding-left:3px;padding-right:3px;']) !!}
                            <span class="input-group-addon" style="padding-right: 3px;padding-left: 3px;">
                                <small>{{ $subCategory->unit }}</small>
                            </span>
                            @if($subCategory->use_second_unit)
                            {!! Form::text('expense_second_quantity', $defaultSecondQuantity, ['class'=>'form-control text-right input-sm','style'=>'padding-left:3px;padding-right:3px;']) !!}
                            <span class="input-group-addon" style="padding-right: 3px;padding-left: 3px;">
                                <small>{{ $subCategory->second_unit }}</small>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="padding-left: 5px;padding-right: 5px;">
                    <div class="">
                        <div><label for="">
                            <div>Amount <small>before VAT</small> <span class="text-danger">*</span></div>
                            <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                        </label></div>
                        <div class="input-group">
                            {!! Form::text('expense_amount', $defaultAmount, ['class'=>'form-control input-sm text-right']) !!}
                            <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">
                                {{ $receipt->currency_id }}
                            </span>
                        </div>
                    </div>
                    <div class="text-navy">
                        @if(isset($rateExpense))
                            <small>
                            @if(!$rateExpense->unlimit)
                                Policy Rate = {{ number_format($rateExpense->rate,2) }} {{ $parentCurrencyId }} / {{ $subCategory->unit }}
                                @if($subCategory->use_second_unit)
                                 / {{ $subCategory->second_unit }}
                                @endif
                            @else
                                Policy Rate = Unlimit (ไม่จำกัด)
                            @endif
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-right " style="padding-left: 5px;padding-right: 5px;">
                    <div class="hidden-sm hidden-xs"><label for="">
                        <div>&nbsp;</div>
                        <div><small>&nbsp;</small></div>
                    </label></div>
                    <div class="checkbox">
                        <label>
                        @if($showInputVat)
                            {!! Form::checkbox('cal_expense_vat', true, $calVat ) !!} 
                            Calculate VAT (คิดภาษีมูลค่าเพิ่ม) ?
                        @else
                            &nbsp;
                        @endif
                        </label>
                    </div>
                    {!! Form::hidden('expense_vat_id', $defaultVatId) !!}
                    {!! Form::hidden('expense_amount_inc_vat', $defaultAmountIncVat) !!}
                    @if($exchangeRate != 1) 
                    <div>
                        <small>Exchange Rate (อัตราแลกเปลี่ยน) = {{ number_format($exchangeRate,2) }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if($policyMileage)
        {{-- ========================== --}}
        {{-- ==== TAB MILEAGE FORM ==== --}}
        {{-- ========================== --}}
        <div id="tab-mileage" class="tab-pane {{ !$policyExpense ? 'active':'' }}">
            <div class="panel-body">
                <div class="col-md-12">
                    {{-- NOW USE ONLY DISTANCE TRAVELED 20/3/2017 --}}
                    <div class="row m-b-sm hide"> 
                        <div class="col-sm-12">
                            <div>
                                <label>
                                    <div>Calculate Mileage Using</div>
                                    <div><small>คำนวนโดยใช้</small></div>
                                </label>
                            </div>
                            <div>
                                <label class="radio-inline"> 
                                    {!! Form::radio('cal_mileage_by', 'distance_traveled', true) !!} 
                                    Distance Traveled 
                                    <small>(ค่าระยะทาง)</small>
                                </label>
                                <label class="radio-inline"> 
                                    {!! Form::radio('cal_mileage_by', 'odometer_reading', false) !!} 
                                    Odometer Reading 
                                    <small>(ค่าตามมาตรวัดระยะทาง)</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row m-b-xs">
                        <div id="div_odermeter_reading" class="col-sm-5 hide">
                            <div>
                                <label>
                                    <div>Odometer Reading <span class="text-danger">*</span></div>
                                    <div><small>(ค่าตามมาตรวัดระยะทาง)</small></div>
                                </label> 
                            </div>
                            <div class="input-group">
                                {!! Form::text('mileage_start', null, ['class'=>'form-control input-sm']) !!}
                                <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">
                                    to
                                </span>
                                {!! Form::text('mileage_end', null, ['class'=>'form-control input-sm']) !!}
                            </div>
                        </div>
                        <div id="div_mileage_distance" class="col-sm-6">
                            <div>
                                <label>
                                    <div>Distance <span class="text-danger">*</span></div>
                                    <div><small>ระยะทาง</small></div>
                                </label> 
                            </div>
                            <div class="input-group">
                                {!! Form::text('mileage_distance', $defaultMileageDistance, ['class'=>'form-control input-sm text-right']) !!}
                                <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">
                                    {{ $mileageUnitLists[$baseMileageUnit] }}
                                </span>
                            </div>
                        </div>
                        <div id="div_mileage_amount" class="col-sm-6">
                                <div><label>
                                    <div>Amount</div>
                                    <div><small>ยอดเงิน</small></div>
                                </label></div>
                            <div class="input-group">
                                {!! Form::text('mileage_amount', $defaultAmount, ['class'=>'form-control input-sm text-right','readonly'=>'readonly']) !!}
                                <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">
                                    {{ $parentCurrencyId }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row m-b-sm">
                        <div class="col-sm-12">
                            <div class="text-navy">
                            @if(isset($rateMileage))
                                Rate = {{ number_format($rateMileage->rate,2) }} {{ $parentCurrencyId }} per {{ $mileageUnitLists[$baseMileageUnit] }}
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!$policyExpense && !$policyMileage)
        {{-- ========================= --}}
        {{-- ==== TAB ACTUAL FORM ==== --}}
        {{-- ========================= --}}
        <div id="tab-actual" class="tab-pane active">
            <div class="panel-body">
                <div class="col-md-3" style="padding-left: 5px;padding-right: 5px;">
                    <div class="m-b-sm">
                        <div><label for="">
                            <div>Quantity</div>
                            <div><small>จำนวน</small></div>
                        </label></div>
                        <div class="input-group">
                            {!! Form::text('actual_quantity', $defaultQuantity, ['class'=>'form-control input-sm text-right','style'=>'padding-left:3px;padding-right:3px;']) !!}
                            <span class="input-group-addon" style="padding-right: 3px;padding-left: 3px;">
                                <small>{{ $subCategory->unit }}</small>
                            </span>
                            @if($subCategory->use_second_unit)
                            {!! Form::text('actual_second_quantity', $defaultSecondQuantity, ['class'=>'form-control text-right input-sm','style'=>'padding-left:3px;padding-right:3px;']) !!}
                            <span class="input-group-addon" style="padding-right: 3px;padding-left: 3px;">
                                <small>{{ $subCategory->second_unit }}</small>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="padding-left: 5px;padding-right: 5px;">
                    <div class="">
                        <div><label for="">
                            <div>Amount <small>before VAT</small> <span class="text-danger">*</span></div>
                            <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                        </label></div>
                        <div class="input-group">
                            {!! Form::text('actual_amount', $defaultAmount, ['class'=>'form-control input-sm text-right']) !!}
                            <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">
                                {{ $receipt->currency_id }}
                            </span>
                        </div>
                    </div>
                    <div class="text-navy">
                        <small>
                            Policy Rate = Unlimit (ไม่จำกัด)
                        </small>
                    </div>
                </div>
                <div class="col-md-4 text-right" style="padding-left: 5px;padding-right: 5px;">
                    <div class="hidden-sm hidden-xs"><label for="">
                        <div>&nbsp;</div>
                        <div><small>&nbsp;</small></div>
                    </label></div>
                    <div class="checkbox">
                        <label>
                        @if($showInputVat)
                            {!! Form::checkbox('cal_actual_vat', true, $calVat ) !!} 
                            Calculate VAT (คิดภาษีมูลค่าเพิ่ม) ?
                        @else
                            &nbsp;
                        @endif
                        </label>
                    </div>
                    {!! Form::hidden('actual_vat_id', $defaultVatId) !!}
                    {!! Form::hidden('actual_amount_inc_vat', $defaultAmountIncVat) !!}
                    @if($exchangeRate != 1) 
                    <div>
                        <small>Exchange Rate (อัตราแลกเปลี่ยน) = {{ number_format($exchangeRate,2) }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    </div>

</div>

{{-- INPUT FOR SUBMIT CREATE RECEIPT LINE --}}

{!! Form::hidden('quantity', $defaultQuantity, 
    ['id'=>'txt_receipt_line_quantity']) !!}
{!! Form::hidden('second_quantity', $defaultSecondQuantity, 
    ['id'=>'txt_receipt_line_second_quantity']) !!}

@if(!isset($receiptLine))
    {!! Form::hidden('policy_id', null, 
        ['id'=>'txt_receipt_line_policy_id']) !!}
    {!! Form::hidden('rate_id', null, 
        ['id'=>'txt_receipt_line_rate_id']) !!}
    {!! Form::hidden('amount', null, 
        ['id'=>'txt_receipt_line_amount']) !!}
    {{-- {!! Form::hidden('wht_id', null, 
        ['id'=>'txt_receipt_line_wht_id']) !!} --}}
    {!! Form::hidden('vat_id', null, 
        ['id'=>'txt_receipt_line_vat_id']) !!}
    {!! Form::hidden('amount_inc_vat', null, 
        ['id'=>'txt_receipt_line_amount_inc_vat']) !!}
@else
    {!! Form::hidden('policy_id', $receiptLine->policy_id, 
        ['id'=>'txt_receipt_line_policy_id']) !!}
    {!! Form::hidden('rate_id', $receiptLine->rate_id, 
        ['id'=>'txt_receipt_line_rate_id']) !!}
    {!! Form::hidden('amount', $receiptLine->amount, 
        ['id'=>'txt_receipt_line_amount']) !!}
    {{-- {!! Form::hidden('wht_id', $receiptLine->wht_id, 
        ['id'=>'txt_receipt_line_wht_id']) !!} --}}
    {!! Form::hidden('vat_id', $receiptLine->vat_id, 
        ['id'=>'txt_receipt_line_vat_id']) !!}
    {!! Form::hidden('amount_inc_vat', $receiptLine->amount_inc_vat, 
        ['id'=>'txt_receipt_line_amount_inc_vat']) !!}
@endif

<div class="hr-line-dashed m-t-md m-b-sm"></div>

<div class="row m-t-sm">
    <div class="col-md-4">
        <div class="m-b-sm">
            <div><label for="">
                <div>Amount <small>before VAT</small></div>
                <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
            </label></div>
            @if(!isset($receiptLine))
                {!! Form::text('primary_amount', null, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_amount','readonly'=>'readonly']) !!}
            @else
                {!! Form::text('primary_amount', $receiptLine->primary_amount, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_amount','readonly'=>'readonly']) !!}
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="m-b-sm">
            <div><label for="">
                <div>VAT Amount <span class="text-danger">*</span></div>
                <div><small>ภาษีมูลค่าเพิ่ม</small></div>
            </label></div>
            @if(!isset($receiptLine))
                {!! Form::text('primary_vat_amount', null, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_vat_amount','readonly'=>'readonly']) !!}
            @else
                {!! Form::text('primary_vat_amount', $receiptLine->primary_vat_amount, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_vat_amount','readonly'=>'readonly']) !!}
            @endif
        </div>
    </div>
    <div class="col-md-5">
        <div class="m-b-sm">
            <div><label for="">
                <div>Amount <small>Inc. VAT</small></div>
                <div><small>ยอดเงินรวมภาษีมูลค่าเพิ่ม</small></div>
            </label></div>
            <div class="input-group">
                @if(!isset($receiptLine))
                    {!! Form::text('primary_amount_inc_vat', null, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_amount_inc_vat','readonly'=>'readonly']) !!}
                @else
                    {!! Form::text('primary_amount_inc_vat', $receiptLine->primary_amount_inc_vat, ['class'=>'form-control text-right','style'=>'font-size: 18px;','id'=>'txt_receipt_line_primary_amount_inc_vat','readonly'=>'readonly']) !!}
                @endif
                <span class="input-group-addon" style="font-size: 18px;">
                    {{ $parentCurrencyId }}
                </div>
            </dspan
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        var formId = "{{ $formId }}";

        // USE SECOND QUANTITY
        var useSecondQuantity = "{{ $subCategory->use_second_unit }}";

        // VAT DATA FROM PHP
        var VATs = jQuery.parseJSON(JSON.stringify({!! $VATs->toJson() !!}));

        // POLICY & RATE DATA FROM PHP
        var policyExpense = JSON.stringify({!! $policyExpense ? $policyExpense->toJson() : null !!});
        var policyMileage = JSON.stringify({!! $policyMileage ? $policyMileage->toJson() : null !!});
        if(policyExpense){
            policyExpense = jQuery.parseJSON(policyExpense);
        }
        if(policyMileage){
            policyMileage = jQuery.parseJSON(policyMileage);
        }
        var rateExpense = JSON.stringify({!! isset($rateExpense) ? $rateExpense->toJson() : null !!});
        var rateMileage = JSON.stringify({!! isset($rateMileage) ? $rateMileage->toJson() : null !!});
        if(rateExpense){
            rateExpense = jQuery.parseJSON(rateExpense);
        }
        if(rateMileage){
            rateMileage = jQuery.parseJSON(rateMileage);
        }
        defaultPolicyAndRate();

        // EXCHANGE RATE
        var exchangeRate = parseFloat("{{ $exchangeRate }}");
        
        if(formId == '#form-create-receipt-line'){
            resetFormAmountValue();
        }else if(formId == '#form-edit-receipt-line'){ // EDIT
            let defaultVatId = "{{ $defaultVatId }}";
            if(defaultVatId){
                $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
            }else{
                $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
            }
        }
        bindExpenseFormEvent();
        bindActualFormEvent();
        bindMileageFormEvent();
        bindPrimaryVatAmountEvent();

        // SELECT TAB POLICY
        $('.tab-policy').on('shown.bs.tab', function (e) {
            // var target = $(e.target).attr("href") // activated tab
            let policyId = $(e.target).attr("data-policy-id");
            let rateId = $(e.target).attr("data-rate-id");
            $(formId).find("input[name='policy_id']").val(policyId);
            $(formId).find("input[name='rate_id']").val(rateId);
            resetFormAmountValue();
            $(formId).find("input[name='quantity']").val(1);
            $(formId).find("input[name='second_quantity']").val(1);
            $(formId).find("input[name='amount']").val('');
            // $(formId).find("input[name='wht_id']").val('');
            $(formId).find("input[name='vat_id']").val('');
            $(formId).find("input[name='amount_inc_vat']").val('');
            $(formId).find("input[name='primary_amount']").val('');
            $(formId).find("input[name='primary_vat_amount']").val('');
            $(formId).find("input[name='primary_amount_inc_vat']").val('');
        });

        $(formId).find("input[name='cal_mileage_by']").change(function(){

            var calMileageBy = $(this).val();

            if(calMileageBy == 'distance_traveled'){

                $("#div_odermeter_reading").addClass('hide');

                $(formId).find("input[name='mileage_distance']").removeAttr('readonly');
                $("#div_mileage_distance").removeClass('col-sm-4');
                $("#div_mileage_distance").addClass('col-sm-6');

                $("#div_mileage_amount").removeClass('col-sm-3');
                $("#div_mileage_amount").addClass('col-sm-6');

            }else{ // odometer_reading

                $("#div_odermeter_reading").removeClass('hide');

                $(formId).find("input[name='mileage_distance']").attr('readonly','readonly');
                $("#div_mileage_distance").removeClass('col-sm-6');
                $("#div_mileage_distance").addClass('col-sm-4');

                $("#div_mileage_amount").removeClass('col-sm-6');
                $("#div_mileage_amount").addClass('col-sm-3');
                
            }

        });

        ////////////////////////////////////
        ///// BIND EXPENSE FORM EVENT
        function bindExpenseFormEvent()
        {
            $(formId).find("input[name='expense_quantity']").blur(function(){
                calExpense();
            });
            $(formId).find("input[name='expense_second_quantity']").blur(function(){
                calExpense();
            });
            $(formId).find("input[name='expense_amount']").blur(function(){
                calExpense();
            });
            // $(formId).find("select[name='expense_wht_id']").change(function(){
            //     calExpense();
            // });
            // $(formId).find("select[name='expense_vat_id']").change(function(){
            //     calExpense();
            //     vatId = $(formId).find("select[name='expense_vat_id'] option:selected").val();
            //     if(vatId){
            //         $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
            //     }else{
            //         $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
            //     }
            // });
            $(formId).find("input[name='cal_expense_vat']").change(function(){
                calExpense();
                if($(formId).find("input[name='cal_expense_vat']").is(":checked")){
                    if($(formId).find("input[name='expense_vat_id']").val()){
                        $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
                    }else{
                        $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
                    }
                }else{
                    $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
                }
            });
            // $(formId).find("input[name='expense_amount_inc_vat']").blur(function(){
            //     calExpenseByInc();
            // });
        }

        function calExpense()
        {
            var expenseQuantity = $(formId).find("input[name='expense_quantity']").val();
            var expenseSecondQuantity = 1;
            if(useSecondQuantity == "1"){
                expenseSecondQuantity = $(formId).find("input[name='expense_second_quantity']").val();
            }   
            var expenseAmount = $(formId).find("input[name='expense_amount']").val();
            // var expenseWHTId = $(formId).find("select[name='expense_wht_id'] option:selected").val();
            // var expenseVATId = $(formId).find("select[name='expense_vat_id'] option:selected").val();
            var expenseVATId = '';
            var calExpenseVat = $(formId).find("input[name='cal_expense_vat']").is(':checked');
            if(calExpenseVat){
                expenseVATId = $(formId).find("input[name='expense_vat_id']").val();
            }
            var expenseAmountIncVat = calAmount(expenseAmount, expenseVATId);
            if(expenseAmountIncVat){
                $(formId).find("input[name='expense_amount_inc_vat']").val(expenseAmountIncVat);
            }else{
                $(formId).find("input[name='expense_amount_inc_vat']").val('');
            }

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(expenseAmount,expenseAmountIncVat);
            // calVATAmount(expenseAmount, expenseVATId);
            setInputAmount(expenseQuantity,expenseSecondQuantity,expenseAmount, expenseVATId, expenseAmountIncVat);

        }

        function calExpenseByInc()
        {
            var expenseQuantity = $(formId).find("input[name='expense_quantity']").val();
            var expenseSecondQuantity = 1;
            if(useSecondQuantity == "1"){
                expenseSecondQuantity = $(formId).find("input[name='expense_second_quantity']").val();
            }   
            var expenseAmountIncVat = $(formId).find("input[name='expense_amount_inc_vat']").val();
            // var expenseWHTId = $(formId).find("select[name='expense_wht_id'] option:selected").val();
            // var expenseVATId = $(formId).find("select[name='expense_vat_id'] option:selected").val();
            var expenseVATId = '';
            var calExpenseVat = $(formId).find("input[name='cal_expense_vat']").is(':checked');
            if(calExpenseVat){
                expenseVATId = $(formId).find("input[name='expense_vat_id']").val();
            }
            var expenseAmount = calAmountByInc(expenseAmountIncVat, expenseVATId);
            if(expenseAmount){
                $(formId).find("input[name='expense_amount']").val(expenseAmount);
            }else{
                $(formId).find("input[name='expense_amount']").val('');
            }

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(expenseAmount,expenseAmountIncVat);
            // calVATAmount(expenseAmount, expenseVATId);
            setInputAmount(expenseQuantity,expenseSecondQuantity,expenseAmount, expenseVATId, expenseAmountIncVat);

        }

        ////////////////////////////////////
        ///// BIND MILEAGE FORM EVENT
        function bindMileageFormEvent()
        {
            $(formId).find("input[name='mileage_start']").blur(function(){
                calMileageByOdometer();
            });
            $(formId).find("input[name='mileage_end']").blur(function(){
                calMileageByOdometer();
            });
            $(formId).find("input[name='mileage_distance']").blur(function(){
                var calMileageBy = $(formId).find("input[name='cal_mileage_by']:checked").val();
                if(calMileageBy == 'distance_traveled'){
                    calMileageByDistance();
                }
            });
        }

        function calMileageByOdometer()
        {
            var mileageAmount = 0;
            var mileageDistance = 0;
            var mileageStart = $(formId).find("input[name='mileage_start']").val();
            var mileageEnd = $(formId).find("input[name='mileage_end']").val();
            if(validateMileage()) {
                mileageDistance = parseFloat(mileageEnd)-parseFloat(mileageStart);
                mileageAmount = calMileageAmount(mileageDistance);
            }
            $(formId).find("input[name='mileage_distance']").val(mileageDistance);
            $(formId).find("input[name='mileage_amount']").val(mileageAmount);

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(mileageAmount,mileageAmount,'mileage');
            // calVATAmount(mileageAmount,null,'mileage');
            setInputAmount(1,1,mileageAmount, '', mileageAmount);
        }

        function calMileageByDistance()
        {
            var mileageAmount = 0
            var mileageDistance = $(formId).find("input[name='mileage_distance']").val();
            if(validateMileage()){
                mileageAmount = calMileageAmount(mileageDistance);
            }
            $(formId).find("input[name='mileage_start']").val('');
            $(formId).find("input[name='mileage_end']").val('');
            $(formId).find("input[name='mileage_amount']").val(mileageAmount);

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(mileageAmount,mileageAmount,'mileage');
            // calVATAmount(mileageAmount,null,'mileage');
            setInputAmount(1,1,mileageAmount, '', mileageAmount);
        }

        function calMileageAmount(mileageDistance)
        {
            if(rateMileage){
                return (parseFloat(rateMileage.rate) * parseFloat(mileageDistance)).toFixed(2);
            }
            return 0;
        }

        function validateMileage()
        {
            $(formId).find("input[name='mileage_start']").parent().next("div.error_msg").remove();
            $(formId).find("input[name='mileage_start']").removeClass('err_validate');
            $(formId).find("input[name='mileage_end']").parent().next("div.error_msg").remove();
            $(formId).find("input[name='mileage_end']").removeClass('err_validate');
            $(formId).find("input[name='mileage_distance']").parent().next("div.error_msg").remove();
            $(formId).find("input[name='mileage_distance']").removeClass('err_validate');

            var valid = true;
            var calMileageBy = $(formId).find("input[name='cal_mileage_by']:checked").val();
            let mileageStart = $(formId).find("input[name='mileage_start']").val();
            let mileageEnd = $(formId).find("input[name='mileage_end']").val();
            let mileageDistance = $(formId).find("input[name='mileage_distance']").val();

            if(calMileageBy == 'distance_traveled'){

                if(!$.isNumeric(mileageDistance)){
                    valid = false;
                    $(formId).find("input[name='mileage_distance']").addClass('err_validate');
                    $(formId).find("input[name='mileage_distance']").parent().after('<div class="error_msg"> distance must be a number .</div>');
                }else if(!parseFloat(mileageDistance) > 0){
                    valid = false;
                    $(formId).find("input[name='mileage_distance']").addClass('err_validate');
                    $(formId).find("input[name='mileage_distance']").parent().after('<div class="error_msg"> distance must be greater than zero .</div>');
                }

            }else{ // odometer_reading

                if(!$.isNumeric(mileageStart)){
                    valid = false;
                    $(formId).find("input[name='mileage_start']").addClass('err_validate');
                    $(formId).find("input[name='mileage_start']").parent().after('<div class="error_msg"> odometer start must be a number .</div>');
                }else if(!parseFloat(mileageStart) > 0){
                    valid = false;
                    $(formId).find("input[name='mileage_start']").addClass('err_validate');
                    $(formId).find("input[name='mileage_start']").parent().after('<div class="error_msg"> odometer start must be greater than zero .</div>');
                }

                if(!$.isNumeric(mileageEnd)){
                    valid = false;
                    $(formId).find("input[name='mileage_end']").addClass('err_validate');
                    $(formId).find("input[name='mileage_end']").parent().after('<div class="error_msg"> odometer end must be a number .</div>');
                }else if(!parseFloat(mileageEnd) > 0){
                    valid = false;
                    $(formId).find("input[name='mileage_end']").addClass('err_validate');
                    $(formId).find("input[name='mileage_end']").parent().after('<div class="error_msg"> odometer end must be greater than zero .</div>');
                }

                if($.isNumeric(mileageStart) && $.isNumeric(mileageEnd)){
                    if(parseFloat(mileageEnd) < parseFloat(mileageStart)){
                        valid = false;
                        $(formId).find("input[name='mileage_end']").addClass('err_validate');
                        $(formId).find("input[name='mileage_end']").parent().after('<div class="error_msg"> odometer end must be greater than odometer start .</div>');
                    }
                }

            }
            
            return valid;
        }

        ////////////////////////////////////
        ///// BIND ACTUAL FORM EVENT
        function bindActualFormEvent()
        {
            $(formId).find("input[name='actual_quantity']").blur(function(){
                calActual();
            });
            $(formId).find("input[name='actual_second_quantity']").blur(function(){
                calActual();
            });
            $(formId).find("input[name='actual_amount']").blur(function(){
                calActual();
            });
            // $(formId).find("select[name='actual_wht_id']").change(function(){
            //     calActual();
            // });
            // $(formId).find("select[name='actual_vat_id']").change(function(){
            //     calActual();
            //     vatId = $(formId).find("select[name='actual_vat_id'] option:selected").val();
            //     if(vatId){
            //         $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
            //     }else{
            //         $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
            //     }
            // });
            $(formId).find("input[name='cal_actual_vat']").change(function(){
                calActual();
                if($(formId).find("input[name='cal_actual_vat']").is(":checked")){
                    if($(formId).find("input[name='actual_vat_id']").val()){
                        $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
                    }else{
                        $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
                    }
                }else{
                    $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
                }
            });
            // $(formId).find("input[name='actual_amount_inc_vat']").blur(function(){
            //     calActualByInc();
            // });
        }

        function calActual()
        {
            var actualQuantity = $(formId).find("input[name='actual_quantity']").val();
            var actualSecondQuantity = 1;
            if(useSecondQuantity == "1"){
                actualSecondQuantity = $(formId).find("input[name='actual_second_quantity']").val();
            }
            var actualAmount = $(formId).find("input[name='actual_amount']").val();
            // var actualWHTId = $(formId).find("select[name='actual_wht_id'] option:selected").val();
            // var actualVATId = $(formId).find("select[name='actual_vat_id'] option:selected").val();
            var actualVATId = '';
            var calActualVat = $(formId).find("input[name='cal_actual_vat']").is(':checked');
            if(calActualVat){
                actualVATId = $(formId).find("input[name='actual_vat_id']").val();
            }
            var actualAmountIncVat = calAmount(actualAmount, actualVATId);

            if(actualAmountIncVat){
                $(formId).find("input[name='actual_amount_inc_vat']").val(actualAmountIncVat);
            }else{
                $(formId).find("input[name='actual_amount_inc_vat']").val('');
            }

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(actualAmount,actualAmountIncVat);
            // calVATAmount(actualAmount,actualVATId);
            setInputAmount(actualQuantity,actualSecondQuantity,actualAmount, actualVATId, actualAmountIncVat);

        }

        function calActualByInc()
        {
            var actualQuantity = $(formId).find("input[name='actual_quantity']").val();
            var actualSecondQuantity = 1;
            if(useSecondQuantity == "1"){
                actualSecondQuantity = $(formId).find("input[name='actual_second_quantity']").val();
            }
            var actualAmountIncVat = $(formId).find("input[name='actual_amount_inc_vat']").val();
            // var actualWHTId = $(formId).find("select[name='actual_wht_id'] option:selected").val();
            // var actualVATId = $(formId).find("select[name='actual_vat_id'] option:selected").val();
            // var actualVATId = $(formId).find("input[name='actual_vat_id']").val();
            var actualVATId = '';
            var calActualVat = $(formId).find("input[name='cal_actual_vat']").is(':checked');
            if(calActualVat){
                actualVATId = $(formId).find("input[name='actual_vat_id']").val();
            }
            var actualAmount = calAmountByInc(actualAmountIncVat, actualVATId);
            if(actualAmount){
                $(formId).find("input[name='actual_amount']").val(actualAmount);
            }else{
                $(formId).find("input[name='actual_amount']").val('');
            }

            // CALCULATE PRIMARY AMOUNT
            calPrimaryAmount(actualAmount,actualAmountIncVat);
            // calVATAmount(actualAmount,actualVATId);
            setInputAmount(actualQuantity,actualSecondQuantity,actualAmount, actualVATId, actualAmountIncVat);

        }

        ///////////////////////////////////////////
        /// FUNCTION CALCULATION AMOUNT

        function calAmount(amount, vatId)
        {
            if($.isNumeric(amount)) {
                // var whtRate = getWHTRate(whtId);
                // var whtAmount = parseFloat(amount) * (parseFloat(whtRate)/100);
                var vatRate = getVATRate(vatId);
                var vatAmount = parseFloat(amount) * (parseFloat(vatRate)/100);
                
                // return (parseFloat(amount) + whtAmount + vatAmount).toFixed(2);
                return (parseFloat(amount) + vatAmount).toFixed(2);
            }
            return 0;
        }

        function calAmountByInc(amountIncVat, vatId)
        {
            if($.isNumeric(amountIncVat)) {
                // var whtRate = getWHTRate(whtId);
                var vatRate = getVATRate(vatId);

                // return ((100*parseFloat(amountIncVat))/(100+parseFloat(whtRate)+parseFloat(vatRate))).toFixed(2);
                return ((100*parseFloat(amountIncVat))/(100+parseFloat(vatRate))).toFixed(2);
            }
            return 0;
        }

        function calPrimaryAmount(amount,amountIncVat,mileage)
        {
            // DEFAULT DATA
            mileage = typeof mileage !== 'undefined' ? mileage : false;

            var primaryAmount = 0;
            var primaryAmountIncVat = 0;
            var primaryVatAmount = 0;

            if(mileage){ // MILEAGE ONLY USE BASE CURRENCY (NOT CAL EXCHANGE RATE)
                if($.isNumeric(amount)){
                    primaryAmount = parseFloat(amount);
                }
                if($.isNumeric(amountIncVat)){
                    primaryAmountIncVat = parseFloat(amountIncVat);
                }
            }else{ // CALCULATE WITH EXCHANGE RATE
                if($.isNumeric(amount) && $.isNumeric(exchangeRate)){
                    primaryAmount = parseFloat(amount) * exchangeRate;
                }
                if($.isNumeric(amountIncVat) && $.isNumeric(exchangeRate)) {
                    primaryAmountIncVat = parseFloat(amountIncVat) * exchangeRate;
                }
            }

            primaryAmount = primaryAmount.toFixed(2);
            primaryAmountIncVat = primaryAmountIncVat.toFixed(2);
            primaryVatAmount = parseFloat(primaryAmountIncVat) - parseFloat(primaryAmount);
            primaryVatAmount = primaryVatAmount.toFixed(2);

            $(formId).find("input[name='primary_amount']").val(primaryAmount);
            $(formId).find("input[name='primary_amount_inc_vat']").val(primaryAmountIncVat);
            $(formId).find("input[name='primary_vat_amount']").val(primaryVatAmount);
        }

        function bindPrimaryVatAmountEvent()
        {
            $(formId).find("input[name='primary_vat_amount']").blur(function(){
                var selectedTabType = $(".tab-form-receipt-line-amount li.active a[data-toggle='tab']").attr('data-tab-type');
                if(selectedTabType != 'mileage'){
                    var amount = $(formId).find("input[name='amount']").val();
                    var primaryAmount = $(formId).find("input[name='primary_amount']").val();
                    var primaryVatAmount = $(formId).find("input[name='primary_vat_amount']").val();
                    calAmountIncVatByPrimaryVatAmount(amount,primaryAmount,primaryVatAmount,selectedTabType);
                }
            });
        }

        function calAmountIncVatByPrimaryVatAmount(amount,primaryAmount,primaryVatAmount,selectedTabType)
        {
            var vatAmount = 0;
            if($.isNumeric(exchangeRate)){ 
                vatAmount = parseFloat(primaryVatAmount) / parseFloat(exchangeRate);
            }else{
                vatAmount = parseFloat(primaryVatAmount);
            }

            var amountIncVat = parseFloat(amount) + parseFloat(vatAmount);
            var primaryAmountIncVat = parseFloat(primaryAmount) + parseFloat(primaryVatAmount);
            
            amountIncVat = amountIncVat.toFixed(2);
            primaryAmountIncVat = primaryAmountIncVat.toFixed(2);

            if(selectedTabType == 'expense'){
                $(formId).find("input[name='expense_amount_inc_vat']").val(amountIncVat);
            }else if(selectedTabType == 'actual'){
                $(formId).find("input[name='actual_amount_inc_vat']").val(amountIncVat);
            }

            $(formId).find("input[name='amount_inc_vat']").val(amountIncVat);
            $(formId).find("input[name='primary_amount_inc_vat']").val(primaryAmountIncVat);
        }

        // function calVATAmount(amount, vatId, mileage)
        // {
        //     // DEFAULT DATA
        //     mileage = typeof mileage !== 'undefined' ? mileage : false;

        //     var primaryAmount = 0;
        //     var vatRate = 0;
        //     var primaryVatAmount = 0;

        //     if(mileage){ // MILEAGE ONLY USE BASE CURRENCY (NOT CAL EXCHANGE RATE)
        //         if($.isNumeric(amount)){
        //             primaryAmount = parseFloat(amount);
        //         }
        //     }else{ // CALCULATE WITH EXCHANGE RATE
        //         if($.isNumeric(amount) && $.isNumeric(exchangeRate)){
        //             primaryAmount = parseFloat(amount) * exchangeRate;
        //         }
        //         vatRate = getVATRate(vatId);
        //         primaryVatAmount = parseFloat(primaryAmount) * parseFloat(vatRate) / 100;
        //     }

        //     primaryVatAmount = primaryVatAmount.toFixed(2);

        //     $(formId).find("input[name='primary_vat_amount']").val(primaryVatAmount);
        // }

        function setInputAmount(quantity,secondQuantity,amount, vatId, amountIncVat)
        {
            $(formId).find("input[name='quantity']").val(quantity);
            $(formId).find("input[name='second_quantity']").val(secondQuantity);
            $(formId).find("input[name='amount']").val(amount);
            // $(formId).find("input[name='wht_id']").val(whtId);
            $(formId).find("input[name='vat_id']").val(vatId);
            $(formId).find("input[name='amount_inc_vat']").val(amountIncVat);
        }

        // function getWHTRate(wht_id) { 
        //     var array = WHTs;
        //     if(wht_id != ''){
        //         for(i in array) {
        //             if(array[i].pay_awt_group_id == wht_id) {
        //               return array[i].tax_rate;
        //             }
        //         }
        //     }
        //     return 0;
        // };

        function getVATRate(vat_id) 
        { 
            var array = VATs;
            if(vat_id != ''){
                for(i in array) {
                    if(array[i].tax_rate_code == vat_id) {
                      return array[i].percentage_rate;
                    }
                }
            }
            return 0;
        };

        $( document ).ajaxStart(function() {
            disableFormAmount();
        });

        $( document ).ajaxStop(function() {
            enableFormAmount();
        });

        function defaultPolicyAndRate()
        {
            let policyId = '';
            let rateId = '';
            if(policyExpense){
                policyId = policyExpense.id;
                rateId = rateExpense.id;
            }else if(policyMileage){
                policyId = policyMileage.id;
                rateId = rateMileage.id;
            }
            $(formId).find("input[name='policy_id']").val(policyId);
            $(formId).find("input[name='rate_id']").val(rateId);
        }

        function resetFormAmountValue()
        {
            var defaultQuantity = "{{ $defaultQuantity }}";
            var defaultSecondQuantity = "{{ $defaultSecondQuantity }}";
            // activated tab type
            var selectedTabType = $(".tab-form-receipt-line-amount li.active a[data-toggle='tab']").attr('data-tab-type');
            if(selectedTabType == 'mileage'){
                $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
            }else{
                var calVat = false;
                var vatId = '';
                if(selectedTabType == 'expense'){
                    calVat = $(formId).find("input[name='cal_expense_vat']").is(':checked');
                    // vatId = $(formId).find("select[name='expense_vat_id'] option:selected").val();
                    vatId = $(formId).find("input[name='expense_vat_id']").val();
                }else if(selectedTabType == 'actual'){
                    calVat = $(formId).find("input[name='cal_actual_vat']").is(':checked');
                    // vatId = $(formId).find("select[name='actual_vat_id'] option:selected").val();
                    vatId = $(formId).find("input[name='actual_vat_id']").val();
                }
                if(calVat && vatId){
                    $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
                }else{
                    $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
                }
            }
            $(formId).find("input[name='expense_quantity']").val(defaultQuantity);
            $(formId).find("input[name='expense_second_quantity']").val(defaultSecondQuantity);
            $(formId).find("input[name='expense_amount']").val('');
            $(formId).find("input[name='expense_amount_inc_vat']").val('');
            // $(formId).find("select[name='expense_wht_id']").val('');
            // $(formId).find("select[name='expense_vat_id']").val('');

            $(formId).find("input[name='mileage_start']").val('');
            $(formId).find("input[name='mileage_end']").val('');
            $(formId).find("input[name='mileage_distance']").val('');

            $(formId).find("input[name='actual_quantity']").val(defaultQuantity);
            $(formId).find("input[name='actual_second_quantity']").val(defaultSecondQuantity);
            $(formId).find("input[name='actual_amount']").val('');
            $(formId).find("input[name='actual_amount_inc_vat']").val('');
            // $(formId).find("select[name='actual_wht_id']").val('');
            // $(formId).find("select[name='actual_vat_id']").val('');
        }

        function disableFormAmount()
        {
            $(formId).find("input[name='expense_quantity']").attr('disabled','disabled');
            $(formId).find("input[name='expense_second_quantity']").attr('disabled','disabled');
            $(formId).find("input[name='expense_amount']").attr('disabled','disabled');
            $(formId).find("input[name='expense_amount_inc_vat']").attr('disabled','disabled');
            // $(formId).find("select[name='expense_wht_id']").attr('disabled','disabled');
            // $(formId).find("select[name='expense_vat_id']").attr('disabled','disabled');

            $(formId).find("input[name='mileage_start']").attr('disabled','disabled');
            $(formId).find("input[name='mileage_end']").attr('disabled','disabled');
            $(formId).find("input[name='mileage_distance']").attr('disabled','disabled');

            $(formId).find("input[name='actual_quantity']").attr('disabled','disabled');
            $(formId).find("input[name='actual_second_quantity']").attr('disabled','disabled');
            $(formId).find("input[name='actual_amount']").attr('disabled','disabled');
            $(formId).find("input[name='actual_amount_inc_vat']").attr('disabled','disabled');
            // $(formId).find("select[name='actual_wht_id']").attr('disabled','disabled');
            // $(formId).find("select[name='actual_vat_id']").attr('disabled','disabled');
            // $(formId).find("input[name='primary_vat_amount']").attr('readonly','readonly');
        }

        function enableFormAmount()
        {
            $(formId).find("input[name='expense_quantity']").removeAttr('disabled','disabled');
            $(formId).find("input[name='expense_second_quantity']").removeAttr('disabled','disabled');
            $(formId).find("input[name='expense_amount']").removeAttr('disabled','disabled');
            $(formId).find("input[name='expense_amount_inc_vat']").removeAttr('disabled','disabled');
            // $(formId).find("select[name='expense_wht_id']").removeAttr('disabled','disabled');
            // $(formId).find("select[name='expense_vat_id']").removeAttr('disabled','disabled');

            $(formId).find("input[name='mileage_start']").removeAttr('disabled','disabled');
            $(formId).find("input[name='mileage_end']").removeAttr('disabled','disabled');
            $(formId).find("input[name='mileage_distance']").removeAttr('disabled','disabled');

            $(formId).find("input[name='actual_quantity']").removeAttr('disabled','disabled');
            $(formId).find("input[name='actual_second_quantity']").removeAttr('disabled','disabled');
            $(formId).find("input[name='actual_amount']").removeAttr('disabled','disabled');
            $(formId).find("input[name='actual_amount_inc_vat']").removeAttr('disabled','disabled');
            // $(formId).find("select[name='actual_wht_id']").removeAttr('disabled','disabled');
            // $(formId).find("select[name='actual_vat_id']").removeAttr('disabled','disabled');
            // $(formId).find("input[name='primary_vat_amount']").removeAttr('readonly');
        }
        
    });

</script>