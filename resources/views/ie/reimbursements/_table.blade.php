<div class="table-responsive">
    <table class="table table-striped" id="tableReimbursements">
        <thead>
            <tr>
                <th width="12%" class="text-center">
                    <div class="hidden-xs">Status</div>
                    <div class="hidden-xs">สถานะ</div>
                </th>
                <th width="15%">
                    <div class="hidden-sm hidden-xs">Document #</div>
                    <div class="hidden-sm hidden-xs">หมายเลขเอกสาร</div>
                    <div class="show-sm-only show-xs-only">Doc #</div>
                    <div class="show-sm-only show-xs-only">เอกสาร #</div>
                </th>
                <th width="12%" title="Request Date" class="hidden-sm hidden-xs">
                    <div>Req. Date</div>
                    <div>วันที่ขอเบิก</div>
                </th>
                <th width="20%" class="hidden-xs">
                    <div>Requester</div>
                    <div>ผู้ขอเบิก</div>
                </th>
                <th width="20%" class="hidden-sm hidden-xs">
                    <div>Pending User</div>
                    <div>ผู้ที่กำลังดำเนินการ</div>
                </th>
                <th width="15%" class="text-right">
                    <div>Amount</div>
                    <div>จำนวนเงิน</div>
                </th>
                <th width="3%" class="no-sort hidden-sm hidden-xs" style="padding-left: 0px;padding-right: 0px;"></th>
                <th width="10%" class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
        @if(count($reims) > 0)
            @foreach($reims as $reim)
                <tr>
                    <td class="text-center no-sort">
                        <span class="hidden-xs">
                            {!! statusIconREIM($reim->status) !!}
                        </span>
                        <span class="show-xs-only">
                            {!! statusMiniIconREIM($reim->status) !!}
                        </span>
                    </td>
                    <td>{{ $reim->document_no }}</td>
                    <td class="hidden-sm hidden-xs">{{ dateFormatDisplay($reim->created_at) }}</td>
                    <td class="hidden-xs">{{ $reim->user ? $reim->user->name : '-' }}</td>
                    <td class="hidden-sm hidden-xs">{{ $reim->pending_user }}</td>
                    <td class="text-right">{{ $reim->total_receipt_amount ? number_format($reim->total_receipt_amount,2) : '-' }}</td>
                    <td class="hidden-sm hidden-xs" style="padding-left: 0px;padding-right: 0px;">
                        {{ $reim->currency_id }}
                    </td>
                    <td class="text-right no-sort"> 
                        <a class="btn btn-xs btn-block btn-primary btn-outline" href="{{ route('ie.reimbursements.show', $reim->id) }}">
                            <i class="fa fa-file-text-o"></i> view
                        </a>
                        @if(isset($allowDuplicate))
                            <a id="btn_duplicate_{{ $reim->id }}" 
                                data-id="{{ $reim->id }}"
                                class="btn btn-xs btn-block btn-info btn-outline">
                                <i class="fa fa-copy"></i> duplicate
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="9">
                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
    