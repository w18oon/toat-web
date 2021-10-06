<div class="col-md-9">
    <div class="row">
        <div class="col-md-6">
            <p style="font-size: 1.1em">
                Document # : {{ $reim->document_no }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <span>{!! statusIconREIM($reim->status) !!}</span>
        </div>
    </div>
    <hr class="m-t-sm">
</div>
<div class="col-md-3">
    <div class="clearfix">
        <small class="font-bold">Reimbursement (จำนวนเงินที่เบิก)</small>
        <div class="text-right m-t-sm">
            <h2 style="font-size: 36px" class="no-margins">
                <span id="receipt_grand_total_amount">
                    {{ number_format($reimTotalAmount,2) }}
                </span>
                <small>{{ $reim->currency_id }}</small>
            </h2>
        </div>
    </div>
    <hr class="m-b-xs">
</div>