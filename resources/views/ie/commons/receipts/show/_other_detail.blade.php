<div class="m-l-sm clearfix">
    <div class="clearfix">
        <p class="font-bold">Attachments (ไฟล์แนบ) </p>
    </div>
	@if(count($receipt->attachments) > 0)
    <div class="clearfix m-b-sm mini-scroll-bar" 
         style="max-height: 600px;overflow: auto;">
        @foreach($receipt->attachments as $attachment)
            @include('commons.receipts._attachments')
        @endforeach
    </div>
    @endif
</div>