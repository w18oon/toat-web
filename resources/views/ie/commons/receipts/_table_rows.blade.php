@if(count($receipts) > 0)
    @foreach($receipts as $receipt)
    <tr style="background-color:#FCFCFC;">
        <td>
            <a style="margin-right: 5px"
                class="receipt-collapse-row"
                data-receipt="{{ $receipt->id }}">
                <i class="fa fa-caret-down"></i>
            </a>
        </td>
        <td>{{ $receipt->receipt_number ? $receipt->receipt_number : '-'  }}</td>
        <td class="hidden-sm hidden-xs">{{ $receipt->receipt_date ? dateFormatDisplay($receipt->receipt_date) : '-' }}</td>
        {{-- // USE ONLY REIMBURSEMENT && CLEARING --}}
        @if($receiptType == 'REIMBURSEMENT' || $receiptType == 'CLEARING')
        <td class="hidden-xs">
            {{ $receipt->vendor_id ? $receipt->vendor_id == 'other' ? $receipt->vendor_name : $vendorLists[$receipt->vendor_id] : 'None' }}
        </td>
        @endif
        {{-- <td>{{ $receipt->recharge ? $rechargeLists[$receipt->recharge] : '-' }}</td> --}}
        <td class="text-right"> 
            <div id="div_td_receipt_amount_{{ $receipt->id }}">
            {{ count($receipt->lines) > 0 ? number_format($receipt->lines->sum('total_primary_amount_inc_vat'),2) : '0.00' }}<br class="show-xs-only"><small class="texts-muted"> {{ $parentCurrencyId }}</small>
            </div>
        </td>
        <td class="text-right">
            {{-- RECEIPT BUTTON --}}
            @include('commons.receipts._btn')
        </td>
    </tr>
    <tr style="border-style: none;" id="tr_{{ $receipt->id }}">
        <td colspan="1" style="font-size: 0.9em;padding-top: 0px;"></td>
        <td colspan="6" style="font-size: 0.9em;padding-top: 0px;">
            {{-- RECEIPT LINES TABLE --}}
            @include('commons.receipts.lines._table',['removable'=>true])
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="7">
            <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">
                Not Found Receipt.
            </h2>
        </td>
    </tr>
@endif