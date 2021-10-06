<div class="row clearfix">
    <div class="col-md-6">
        <div class="m-b-sm">
            <div><label for="">
                <div>Branch <span class="text-danger">*</span></div>
                <div><small>ค่าใช้จ่ายของสาขา</small></div>
            </label></div>
            {!! Form::select('branch_code', $branchLists, $defaultBranchCode,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_branch_id", "autocomplete" => "off","style"=>"font-size:12px;width:100%"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="m-b-sm">
            <div><label for="">
                <div>Department <span class="text-danger">*</span></div>
                <div><small>ค่าใช้จ่ายของแผนก</small></div>
            </label></div>
            {!! Form::select('department_code', $departmentLists , $defaultDepartmentCode,  ["class" => 'form-control input-sm select2', "id"=>"ddl_receipt_line_department_id", "autocomplete" => "off","style"=>"font-size:12px;width:100%"]) !!}
        </div>
    </div>
</div>
@if(isset($informations))
	@if(count($informations) > 0)
		<div class="hr-line-dashed m-t-sm m-b-sm"></div>
		<div class="row clearfix">
		@foreach($informations as $index => $info)
			<div class="col-md-4">
				<div class="m-b-sm">
		            <div><label>
		            	{{ $info->attribute_name }}
		            	@if($info->required)
		            		<span class="text-danger">*</span>
		            	@endif
		            </label></div>
		            @if($info->form_type == 'select') {{-- select --}}

						{!! Form::select('sub_category_infos['.$info->id.']', $info->input_form_value, isset($receiptInfoLists) ? array_key_exists($info->id, $receiptInfoLists) ? $receiptInfoLists[$info->id] : null : null , [
								'class' => 'form-control input-sm',
								'style'=>'font-size: 12px;',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->id]) !!}

		            @elseif($info->form_type == 'date') {{-- date --}}

						@if(!isset($receiptInfoLists))
							{!! Form::text('sub_category_infos['.$info->id.']', $info->input_form_value , [
								'class' => 'form-control input-sm date-picker info-date-picker',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->id]) !!}
						@else
							{!! Form::text('sub_category_infos['.$info->id.']', isset($receiptInfoLists) ? array_key_exists($info->id, $receiptInfoLists) ? dateFormatDisplay($receiptInfoLists[$info->id]) : null : null , [
								'class' => 'form-control input-sm date-picker info-date-picker',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->id]) !!}

						@endif

		            @else {{-- text --}}

						@if(!isset($receiptInfoLists))
							{!! Form::text('sub_category_infos['.$info->id.']', $info->input_form_value , [	'class' => 'form-control input-sm',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->id]) !!}
						@else
							{!! Form::text('sub_category_infos['.$info->id.']', isset($receiptInfoLists) ? array_key_exists($info->id, $receiptInfoLists) ? $receiptInfoLists[$info->id] : null : null , [	'class' => 'form-control input-sm',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->id]) !!}
						@endif

		            @endif
		        </div>
			</div>
		@if(($index+1)%3 == 0)
		{!! '</div><div class="row">' !!}
		@endif
		@endforeach
		</div>
	@endif
@endif

<script>
    $(document).ready(function() {

        $('.info-date-picker').datepicker({
            format: "{{ trans('date.js-format') }}",
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $("#ddl_receipt_line_branch_id,#ddl_receipt_line_department_id")

    });
</script>
