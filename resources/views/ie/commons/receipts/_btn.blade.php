{{-- VIEW BUTTON --}}
<a href="{{ route('receipts.show',[$receipt->id]) }}" title="View" 
    class="btn btn-block btn-white btn-xs" target="_blank"> 
    <i class="fa fa-search"></i> VIEW
</a>
{{-- ACTION BUTTON SHOW ONLY REQUESTER --}}
@if($receipt->parent->isRequester() && $receipt->isNotLock())

<div class="btn-group btn-block">
    <button data-toggle="dropdown" class="btn btn-block btn-white btn-xs dropdown-toggle">
        ACTION <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-receipt receipt-menu">
        <li>
            <a type="button" id="btn_add_receipt_line_{{ $receipt->id }}" 
               data-receipt-id="{{ $receipt->id }}" class="text-navy" title="Add Line">
                <i class="fa fa-plus"></i>&nbsp; Add Line
            </a>
        </li>
        <li>
            <a type="button" id="btn_edit_receipt_{{ $receipt->id }}" 
               data-receipt-id="{{ $receipt->id }}" class="text-warning" title="Edit">
                <i class="fa fa-pencil-square-o"></i>&nbsp; Edit
            </a>
        </li>
        <li>
            <a type="button" id="btn_duplicate_receipt_{{ $receipt->id }}" 
               data-receipt-id="{{ $receipt->id }}" class="text-info" 
               title="Duplicate">
                <i class="fa fa-copy"></i>&nbsp; Duplicate
            </a>
        </li>
        <li>
            <a type="button" id="btn_remove_receipt_{{ $receipt->id }}" 
               data-receipt-id="{{ $receipt->id }}" class="text-danger" 
               title="Remove">
                <i class="fa fa-times"></i>&nbsp; Remove
            </a>
        </li>
    </ul>
</div>

@endif