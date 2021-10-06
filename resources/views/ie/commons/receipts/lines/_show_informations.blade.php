{{-- RECEIPT LINE MAIN INFORMATIONS --}}
<div class="row">
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
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Branch</div>
                <div><small>ค่าใช้จ่ายของสาขา</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ array_key_exists($receiptLine->branch_code, $branchLists) ? $branchLists[$receiptLine->branch_code] : '-'  }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Department</div>
                <div><small>ค่าใช้จ่ายของแผนก</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ array_key_exists($receiptLine->department_code, $departmentLists) ? $departmentLists[$receiptLine->department_code] : '-' }}</p>
            </div>
        </div>
    </div>
</div>

{{-- FROM SUB-CATEGORIES INFORMATIONS --}}
@if(count($receiptLine->infos) > 0)
	<div class="hr-line-dashed m-t-sm m-b-sm"></div>
	<div class="row">
	@foreach($receiptLine->infos as $index => $info)
		<div class="col-md-4">
			<div>
	            <div><label><small>
	            	{{ $info->subCategoryInfo->attribute_name }}
	            </small></label></div>
	            <p class="form-control-static">
	               {{ $info->description_for_show }}
	            </p>
	        </div>
		</div>
	@if(($index+1)%3 == 0)
	{!! '</div><div class="row">' !!}
	@endif
	@endforeach
	</div>
@endif

@if($receiptLine->policy)

    @if($receiptLine->policy->typeMileage())

    {{-- MILEAGE INFORMATIONS --}}

    <div class="hr-line-dashed m-t-sm m-b-sm"></div>

    <div class="row text-right">

        {{-- <div class="col-sm-6">
            <div>
                <label><small>
                    <div>Odometer Reading</div>
                    <div><small>ค่าจากมาตรวัดระยะทาง</small></div>
                </small></label>
            </div>
            <div class="row">
    	        <div class="col-sm-4">
    	            <p class="form-control-static text-center">
    	            {{ $receiptLine->mileage_start ? number_format($receiptLine->mileage_start,2) : '-' }}
    	            </p>
    	        </div>
    	        <div class="col-sm-2">
    	            <p class="form-control-static text-center">to</p>
    	        </div>
    	        <div class="col-sm-4">
    	            <p class="form-control-static text-center">
    	            {{ $receiptLine->mileage_end ? number_format($receiptLine->mileage_end,2) : '-' }}
    	            </p>
    	        </div>
            </div>
        </div> --}}
        
        <div class="col-md-7 col-md-offset-5">
            <div class="row text-right">
                <div class="col-sm-6"> 
                    <label>
                        <div>Distance</div>
                        <div><small>ระยะทาง</small></div>
                    </label>
                </div>
                <div class="col-sm-6"> 
                    <span style="font-size: 20px;">
                        {{ $receiptLine->mileage_distance ? number_format($receiptLine->mileage_distance,2) : '-' }}
                    </span>
            		<span>{{ $mileageUnitLists[$baseMileageUnit] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-b-sm text-right">
        <div class="col-sm-12">
            <div class="text-navy">
            @if(isset($receiptLine->rate))
                Rate = {{ number_format($receiptLine->rate->rate,2) }} {{ $parentCurrencyId }} per {{ $mileageUnitLists[$baseMileageUnit] }}
            @endif
            </div>
        </div>
    </div>

    @endif
    
@endif

{{-- AMOUNT INFORMATIONS --}}

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

<div class="row m-t-lg m-b-sm">
    <div class="col-md-2">
        <div class="row text-right">
            <div class="col-sm-6"> 
                <label><small>
                    <div>Quantity</div>
                    <div><small>จำนวน</small></div>
                </small></label> 
            </div>
            <div class="col-sm-6">
                @if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ '-' }}
                    @else {{-- EXPENSE --}}
                        {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                        <span>{{ $receiptLine->subCategory->unit }}</span>
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                    <span>{{ $receiptLine->subCategory->unit }}</span>
                @endif
                @if($receiptLine->subCategory->use_second_unit)
                    @if($receiptLine->policy)
                        @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                            {{ '-' }}
                        @else {{-- EXPENSE --}}
                            {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                            <span>{{ $receiptLine->subCategory->second_unit }}</span>
                        @endif
                    @else {{-- ACTUAL --}}
                        {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                        <span>{{ $receiptLine->subCategory->second_unit }}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
	<div class="col-md-5">
		<div class="row text-right">
        	<div class="col-sm-6"> 
        		<label><small>
                    <div>Amount <small>before VAT</small></div>
                    <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_amount ? number_format($receiptLine->total_amount,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>
        
        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>VAT Amount</div>
                    <div><small>ภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->vat_amount ? number_format($receiptLine->vat_amount,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>
        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>Amount <small>Inc. VAT</small></div>
                    <div><small>ยอดเงินรวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_amount_inc_vat ? number_format($receiptLine->total_amount_inc_vat,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="row text-right">
        	<div class="col-sm-6"> 
        		<label><small>
                    <div>Amount <small>before VAT</small></div>
                    <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_primary_amount ? number_format($receiptLine->total_primary_amount,2) : '0.00' }}
                </span>
        		<span>{{ $parentCurrencyId }}</span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>VAT Amount</div>
                    <div><small>ภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->primary_vat_amount ? number_format($receiptLine->primary_vat_amount,2) : '0.00' }}
                </span>
        		<span>{{ $parentCurrencyId }}</span>
        	</div>
        </div>
        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>Amount <small>Inc. VAT</small></div>
                    <div><small>ยอดเงินรวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <div style="padding-bottom: 5px;border-bottom: 1px solid #DDDDDD;">
                    <span style="font-size: 22px;">
                        {{ $receiptLine->total_primary_amount_inc_vat ? number_format($receiptLine->total_primary_amount_inc_vat,2) : '0.00' }}
                    </span>
            		<span>{{ $parentCurrencyId }}</span>
                </div>
        	</div>
        </div>
    </div>
</div>