<div class="form-group row">
    <label for="name" class="col-md-2 control-label label-no-padding">
        <div>Name <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>ชื่อ</small></div>
    </label>
    <div class="col-md-9">
    @if(isset($sub_category))
        @if(!$sub_category->isAdvanceOver())
            {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
        @else
            {!! Form::hidden('name', $sub_category->name ) !!}
            <p class="form-control-static">{{ $sub_category->name }}</p>
        @endif
    @else
        {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    @endif
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-md-2 control-label label-no-padding">
        <div>Description <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>รายละเอียด</small></div>
    </label>
    <div class="col-md-9">
        {!! Form::text('description', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-8">
        <div class="row">
            <label for="account_code" class="col-sm-3 control-label label-no-padding">
                <div>Account Code <span class="text-danger">*</span></div>
                <div class="m-r-sm"><small>บัญชี</small></div>
            </label>
            <div class="col-sm-6">
                {!! Form::select('account_code', [''=>'-']+$accountLists ,null , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
            </div>
            <div class="col-sm-3" id="div_ddl_sub_account_code">
                <label class="control-label show-xs-only">Sub-Account Code</label>
                {!! Form::select('sub_account_code', [''=>'-'] ,null , ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="vat_id" class="col-md-4 control-label label-no-padding" style="padding-left: 5px">
                <div>VAT Code</div>
                <div><small>รหัสภาษี</small></div>
            </label>
            <div class="col-md-8">
                {!! Form::select('vat_id', [''=>'-']+$VATLists ,null , ["class" => 'form-control select2', "autocomplete " => "off"]) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="branch_code" class="col-md-2 control-label label-no-padding">
        <div>Branch</div>
        <div><small>สาขา</small></div>
    </label>
    <div class="col-md-4">
        {!! Form::select('branch_code', [''=>'-']+$branchLists ,null , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
    </div>
    <label for="department_code" class="col-md-1 control-label label-no-padding">
        <div>Department</div>
        <div><small>แผนก</small></div>
    </label>
    <div class="col-md-4">
        {!! Form::select('department_code', [''=>'-']+$departmentLists ,null , ["class" => 'form-control select2', "autocomplete " => "off"]) !!}
    </div>
</div>
<div class="row">
    <label for="date" class="col-md-2 control-label label-no-padding">
        <div>Date <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>วันที่ใช้งาน</small></div>
    </label>
    <div class="col-md-5">
        <div class="input-group">
        {!! Form::text('start_date', null , ["id" => "start_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        <span class="input-group-addon"> to </span>
        {!! Form::text('end_date', null , ["id" => "end_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="unit" class="col-md-3 control-label label-no-padding" style="padding-left: 5px">
                <div>Unit <span class="text-danger">*</span></div>
                <div class="m-r-sm"><small>หน่วย</small></div>
            </label>
            <div class="col-md-9">
                <div id="div_use_single_unit">
                    {!! Form::text('unit' ,null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    <small style="color: #999">เช่น ต่อครั้ง, ต่อคน, ต่อคืน, ต่อเที่ยวบิน</small>
                </div>
                <div id="div_use_dual_unit" class="hide">
                    <div class="input-group">
                    {!! Form::text('unit_1' ,isset($sub_category) ? $sub_category->use_second_unit ? $sub_category->unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    <span class="input-group-addon"> / </span>
                    {!! Form::text('unit_2' ,isset($sub_category) ? $sub_category->use_second_unit ? $sub_category->second_unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                    <small style="color: #999">เช่น ต่อคน / ต่อคืน, ต่อคน / ต่อเที่ยวบิน</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-9">
        <hr class="hr-line-dashed">
    </div>
</div>

<div class="form-group row clearfix">
    <label class="col-sm-2 control-label label-no-padding">
        <div>ORG <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>บริษัทที่ใช้งาน</small></div>
    </label>
    <div class="col-sm-3 b-r">
        @foreach($operatingUnits as $ou)
        <div><label>
            {!! Form::checkbox('accessible_orgs[]', $ou->organization_id , null) !!} {{ $ou->name }}
        </label></div>
        @endforeach
    </div>
    <div class="col-sm-6">
        <hr class="hr-line-dashed m-t-sm m-b-sm show-xs-only">
        <div class="row">
            <div class="col-sm-12">
                <div class="row" >
                    <div class="col-md-7">
                        <div class="checkbox" style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('allow_exceed_policy', true, !isset($sub_category) ? false : null ,['id'=>'check_allow_exceed_policy']) !!} Allow exceed policy (สามารถเบิกเกินเกณฑ์) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="checkbox" style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('use_second_unit', true, !isset($sub_category) ? false : null ,['id'=>'check_use_second_unit']) !!} Use 2 unit (ใช้งาน 2 หน่วย) ?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-7">
                        <div class="checkbox" style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('required_attachment', true, !isset($sub_category) ? false : null ) !!} Required Document Attachment (จำเป็นต้องแนบไฟล์) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="checkbox" style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('active', true, !isset($sub_category) ? true : null ) !!} Active (ใช้งาน) ?
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="form-group row">
    <div class="col-md-offset-2 col-md-11">
        <button type="submit" class="btn btn-primary" data-disable-with="Processing...">Save</button>
        <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}" class="btn btn-link">cancel</a>
    </div>
</div>

@section('scripts')
@parent
    <script>
        $(document).ready(function() {

            toggleShowUnit($("#check_use_second_unit").checked);

            $(".select2").select2();

            $('.chosen-select').chosen({width: "100%"});

            var defaultSubAccountCode = "{{ $defaultSubAccountCode }}";
            getInputSubAccountCode($("select[name='account_code'] option:selected").val(),defaultSubAccountCode);

            $('#start_date,#end_date').datepicker({
                format: "{{ trans('date.js-format') }}",
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#check_use_second_unit').change(function () {
                toggleShowUnit(this.checked);
            }).change();

            function toggleShowUnit(checked)
            {
                if(checked){
                    $('#div_use_single_unit').addClass('hide');
                    $('#div_use_dual_unit').removeClass('hide');
                }else{
                    $('#div_use_single_unit').removeClass('hide');
                    $('#div_use_dual_unit').addClass('hide');
                }
            }

            $("select[name='account_code']").change(function(){
                var accountCode = $("select[name='account_code'] option:selected").val();
                getInputSubAccountCode(accountCode,'');
            });

            function getInputSubAccountCode(accountCode,subAccountCode){
                $.ajax({
                    url: "{{ url('/') }}/settings/categories/{{ $category->category_id }}/sub_categories/input_sub_account_code",
                    type: 'GET',
                    data: { account_code : accountCode,
                            sub_account_code : subAccountCode },
                    beforeSend: function( xhr ) {
                        $("select[name='sub_account_code']").attr('disabled','disabled');
                    }
                })
                .done(function(result) {
                    $("#div_ddl_sub_account_code").html(result);
                });
            }

        });
    </script>
@endsection