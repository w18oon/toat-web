@if(count($receipt->lines) > 0)    
    @foreach($receipt->lines as $line)
    <tr>
        <td class="td-break-word"> 
            <i class="fa {{ $line->category->icon }}"></i> : 
            {{ $line->subCategory->name }} <br> {{ $line->description }} 
        </td>
        {{-- <td>
            {{ array_key_exists($line->branch_code, $branchLists) ? $branchLists[$line->branch_code] : '-'  }}
        </td> --}}
        <td class="hidden-xs">
            {{ array_key_exists($line->department_code, $departmentLists) ? $departmentLists[$line->department_code] : '-' }}
        </td>
        <td class="text-right hidden-sm hidden-xs">
            @if($line->policy)
                @if($line->policy->typeMileage()) {{-- MILEAGE --}}
                    {{ '-' }}
                @else {{-- EXPENSE --}}
                    {{ $line->quantity ? $line->quantity : '-' }}
                    <span>{{ $line->subCategory->unit }}</span>
                @endif
            @else {{-- ACTUAL --}}
                {{ $line->quantity ? $line->quantity : '-' }}
                <span>{{ $line->subCategory->unit }}</span>
            @endif
            @if($line->subCategory->use_second_unit)
                @if($line->policy)
                    @if($line->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ '-' }}
                    @else {{-- EXPENSE --}}
                        {{ $line->second_quantity ? $line->second_quantity : '-' }}
                        <span>{{ $line->subCategory->second_unit }}</span>
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $line->second_quantity ? $line->second_quantity : '-' }}
                    <span>{{ $line->subCategory->second_unit }}</span>
                @endif
            @endif
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->total_primary_amount ? number_format($line->total_primary_amount,2) : '0.00' }}
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->primary_vat_amount ? number_format($line->primary_vat_amount,2) : '0.00' }}
        </td>
        <td class="text-right" style="padding-right: 2px !important;">
            <div id="td_receipt_line_amount_{{ $line->id }}">
            {{ $line->total_primary_amount_inc_vat ? number_format($line->total_primary_amount_inc_vat,2) : '0.00' }}
            </div>
        </td>
        <td style="padding-left: 2px !important;">
            <small>{{ $parentCurrencyId }}</small>
        </td>
        <td class="text-center"> 
            @if($receipt->parent->isRequester() && $receipt->isNotLock() && isset($removable))
            <div class="clearfix">
                <div class="col-sm-6 padding-btn-receipt-line">
                    <a id="button_show_receipt_line_{{ $line->id }}" type="button" class="btn btn-xs btn-block btn-outline btn-primary" title="View Detail" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->id }}">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
                <div class="col-sm-6 padding-btn-receipt-line">
                    <a id="button_duplicate_receipt_line_{{ $line->id }}" type="button" class="btn btn-xs btn-block btn-outline btn-info" title="Duplicate" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->id }}">
                        <i class="fa fa-copy"></i>
                    </a>
                </div>
            </div>
            <div class="clearfix m-t-xs">
                <div class="col-sm-6 padding-btn-receipt-line">
                    <a id="button_edit_receipt_line_{{ $line->id }}" type="button" class="btn btn-xs btn-block btn-outline btn-success" title="Edit" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                <div class="col-sm-6 padding-btn-receipt-line">
                    <a id="button_remove_receipt_line_{{ $line->id }}" type="button" class="btn btn-xs btn-block btn-outline btn-danger" title="Remove" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->id }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            @else
                <a id="button_show_receipt_line_{{ $line->id }}" type="button" class="btn btn-xs btn-outline btn-block btn-primary" title="View Detail" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->id }}">
                    <i class="fa fa-search"></i>
                </a>
            @endif
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="12">
            <div style="font-size: 18px;color:#AAA;margin-top: 10px;margin-bottom: 10px;"> 
                Not found receipt line. 
            </div>
        </td>
    </tr>
@endif