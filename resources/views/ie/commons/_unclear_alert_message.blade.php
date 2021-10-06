@if(isset($pendingRequestLists))
	@if(count($pendingRequestLists) > 0)
	<div class="alert alert-warning">
	    <p style="font-weight: 700;">
			Pending unclear request(s) <br>
	    	<small>รายการที่ยังไม่ได้เคลียร์</small>
	    </p>
	    <ul class="m-t-sm">
	    @foreach($pendingRequestLists as $pendingRequest)
	        <li>{{ $pendingRequest['document_no'] }}</li>
	    @endforeach
	    </ul>
	    <div class="m-t-sm">
			This request will not be allowed to send request, because you have pending unclear request(s), please contact Finance Dept. <br>
	        <small>รายการที่สร้างจะไม่สามารถส่งไห้ผู้อนุมัติได้หากมีรายการเบิกอื่นๆค้างอยู่, กรุณาติดต่อเจ้าหน้าที่การเงิน</small>
	    </div>
	</div>
	@endif
@endif