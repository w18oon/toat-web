<div class="row m-t-sm m-r-md">

    <div class="col-sm-3 pull-right text-right">
        <div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4>
                <div>Tax Invoice/Receipt #</div>
                <div><small>เลขที่ใบกำกับภาษี/ใบเสร็จ</small></div>
            </h4>
            <p style="font-size: 1.2em" class="text-navy">
                {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }}
            </p>
        </div>
    </div>

    <div class="col-sm-9">

        <dl class="dl-horizontal m-b-xs">
            <dt style="width:200px">
                <div>Date</div>
                <div><small>วันที่ใช้บริการ</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ $receipt->receipt_date ? dateFormatDisplay($receipt->receipt_date) : '-' }}</dd>
        </dl>

        <dl class="dl-horizontal m-b-xs">
            <dt style="width:200px">
                <div><small>Address in Tax Inv.</small></div>
                <div><small>ที่อยู่ในใบกำกับภาษี</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ array_key_exists($receipt->establishment_id, $establishmentLists) ? $establishmentLists[$receipt->establishment_id] : '-' }}</dd>
        </dl>

        @if($receiptType == 'REIMBURSEMENT' || $receiptType == 'CLEARING')
            <dl class="dl-horizontal m-b-xs">
            @if($receipt->vendor_id)
                @if($receipt->vendor_id != 'other')
                    <dt style="width:200px">
                        <div>Vendor</div>
                        <div><small>ผู้ให้บริการ</small></div>
                    </dt>
                    <dd style="margin-left: 220px;">{{ $vendorLists[$receipt->vendor_id] }}</dd>
                @else
                    @if($receipt->vendor_name)
                        <dt style="width:200px">
                            <div>Vendor</div>
                            <div><small>ผู้ให้บริการ</small></div>
                        </dt>
                        <dd style="margin-left: 220px;">{{ $receipt->vendor_name }}</dd>
                    @endif
                    @if($receipt->vendor_tax_id)
                        <dt style="width:200px">
                            <div>Tax ID</div>
                        </dt>
                        <dd style="margin-left: 220px;">{{ $receipt->vendor_tax_id }}</dd>
                    @endif
                    @if($receipt->vendor_branch_name)
                        <dt style="width:200px">
                            <div>Branch Number</div>
                            <div>&nbsp;</div>
                        </dt>
                        <dd style="margin-left: 220px;">{{ $receipt->vendor_branch_name }}</dd>
                    @endif
                @endif
            @else
                <dt style="width:200px">
                    <div>Vendor</div>
                    <div><small>ผู้ให้บริการ</small></div>
                </dt>
                <dd style="margin-left: 220px;">None</dd>
            @endif
            </dl>
        @endif

        <dl class="dl-horizontal m-b-xs">
            <dt style="width:200px">
                <div>Description</div>
                <div><small>รายละเอียด</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ $receipt->jusification ? $receipt->jusification : '-' }}</dd>
        </dl>

        <dl class="dl-horizontal m-b-xs hide">
            <dt style="width:200px">
                <div>Project</div>
                <div><small>โครงการ</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ array_key_exists($receipt->project, $projectLists) ? $projectLists[$receipt->project] : 'N/A' }}</dd>

            <dt style="width:200px">
                <div>Job</div>
                <div><small>งาน</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ $receipt->job }}</dd>

            <dt style="width:200px">
                <div>Recharge</div> 
                <div><small>ชาร์จบริษัท</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ array_key_exists($receipt->recharge, $rechargeLists) ? $rechargeLists[$receipt->recharge] : 'N/A' }}</dd>
        </dl>

    </div>

</div>
