{{-- Requester --}}
<div class="row hidden-sm hidden-xs">
    <label for="" class="col-sm-2 control-label">
        <div>Requester</div>
        <div>ผู้ขอเบิก</div>
    </label>
    <div class="col-sm-3">
        <p class="form-control-static">
        {{ optional(auth()->user())->name }}
        {{-- {{ auth()->user()->employee->full_name }} --}}
        </p>
    </div>
    <label for="" class="col-sm-3 control-label">
        <div>Bank Account</div>
        <div>เลขที่บัญชี</div>
    </label>
    <div class="col-sm-4">
        <p class="form-control-static">
        {{ optional(optional(auth()->user())->employee)->bank_name }} &nbsp; {{ optional(optional(auth()->user())->employee)->bank_account_num }}
        </p>
        {!! Form::hidden('bank_account_id', null ) !!}
    </div>
</div>

<div class="form-group hidden-sm hidden-xs">
    <label for="" class="col-sm-2 control-label">
        <div>Company</div>
        <div>ชื่อบริษัท</div>
    </label>
    <div class="col-sm-3">
        <p class="form-control-static">
        {{-- TMITH --}}
        {{ optional(optional(auth()->user())->employee)->company_name }}
        </p>
        {!! Form::hidden('company_id', null ) !!}
    </div>
    <label for="" class="col-sm-3 control-label">
        <div>Department</div>
        <div>ชื่อแผนก</div>
    </label>
    <div class="col-sm-4">
        <p class="form-control-static">
        {{-- IT --}}
        {{ optional(optional(auth()->user())->employee)->department_name }}
        </p>
        {!! Form::hidden('department_id', null ) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-sm m-b-sm hidden-sm hidden-xs"></div>

<div class="form-group">
    <label for="" class="col-md-2 control-label label-no-padding">
        <div>Purpose <span class="text-danger">*</span></div>
        <div class="m-r-sm">วัตถุประสงค์</div>
    </label>
    <div class="col-md-10">
       {!! Form::textArea('purpose', null , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4"]) !!}
    </div>
</div>
