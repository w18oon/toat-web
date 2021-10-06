
<span id="receiptAttachmentDesc" class="hide">
	<div id="receiptAttachmentDescText"></div>
	<div class="m-t-xs">
		<span id="btnUploadReceiptFile" class="btn btn-sm btn-success btn-outline"
			style="font-size: 10px">
			<i class="fa fa-upload"></i> upload
		</span>
		<span id="btnCancelReceiptFile" class="btn btn-sm btn-danger btn-outline"
			style="font-size: 10px">
			<i class="fa fa-times"></i>
		</span>
	</div>
</span>
{!! Form::open(['route' => ['receipts.add_attachment',$receipt->id], 
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                    'id' => 'form-add-receipt-attachment']) !!}
    {!! Form::hidden('receipt_id',$receipt->id) !!}
	<span id="btnAddReceiptFile" 
		class="fileUpload btn btn-sm btn-primary btn-outline"
		style="font-size: 10px">
	    <i class="fa fa-plus"></i> add file
	    <input id="inputReceiptAttachment" name="file" type="file" class="upload" />
	</span>
{!! Form::close() !!}