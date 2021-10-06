<div class="row">
    <div class="col-md-12 no-padding-xs">
        @if($reim->isRequester() && $reim->isNotLock())
            <div class="text-right m-b-sm mm-sm">
                <button type="button" class="btn btn-primary btn-xs btn-outline" data-toggle="modal" data-target="#modal_create_receipt" data-backdrop="static" data-keyboard="false">Add Receipt</button>
            </div>
        @endif
		<div class="clearfix" id="div_clearing_receipt_list">

	        @include('ie.commons.receipts._table',['parent'=>$reim])

		</div>
    </div>
</div>
<hr class="m-t-sm m-b-xs">

@include('ie.commons.receipts._modal_create')
@include('ie.commons.receipts._modal_edit')