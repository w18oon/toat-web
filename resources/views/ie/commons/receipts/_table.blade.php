<div class="table-responsive">
    <table class="table" id="table_receipts" style="margin-bottom:0px;" >
        <thead>
            <tr>
                <th width="2%"></th>
                <th width="20%" class="">
                    <div>Receipt #</div>
                    <div><small>เลขที่ใบเสร็จ</small></div>
                </th>
                <th width="15%" class="hidden-sm hidden-xs">
                    <div>Date</div>
                    <div><small>วันที่ใช้บริการ</small></div>
                </th>
                @if($receiptType == 'REIMBURSEMENT' || $receiptType == 'CLEARING')
                <th width="20%" class="hidden-xs">
                    <div>Vendor</div>
                    <div><small>ผู้ให้บริการ</small></div>
                </th>
                @endif
                <th width="20%" class="text-right">
                    <div>Amount</div>
                    <div><small>ยอดเงิน</small></div>
                </th>
                <th width="14%" class="text-right"></th>
            </tr>
        </thead>
        <tbody>

            @include('commons.receipts._table_rows')

        </tbody>
    </table>
</div>
<div class="mm-sm">
    <table id="table_receipts_total_rows" class="table table-mini-padding invoice-total m-t-xs mm-xs">
        <tbody>
            @include('commons.receipts._table_total_rows')
        </tbody>
    </table>
</div>

{{-- MODAL CREATE RECEIPT LINE --}}
@include('commons.receipts.lines._modal_create')

{{-- MODAL EDIT RECEIPT LINE --}}
@include('commons.receipts.lines._modal_edit')

{{-- MODAL SHOW RECEIPT LINE --}}
@include('commons.receipts.lines._modal_show')
