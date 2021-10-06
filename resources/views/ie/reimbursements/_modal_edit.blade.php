@if($reim->isRequester() && $reim->isNotLock())
<div id="modal-edit-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="modal-body-edit-form">
				<div class="m-l-xs m-r-lg mm-xs">
	            	{!! Form::model($reim, ['route' => ['ie.reimbursements.update', $reim->id], 'class' => 'form-horizontal', 'method' => 'patch', 'id' => 'form-edit-reimbursement'] ) !!}
					<h3 class="m-b-md">Edit Reimbursement : {{ $reim->document_no }}</h3>
				    <hr class="m-b-xs">
				    <div class="row clearfix">
				        <div class="col-sm-12">
							{{-- FORM REIMBURSEMENT HTML --}}
	            			@include('ie.reimbursements._form')
				        </div>
					</div>
					<hr class="m-t-sm m-b-sm">
					<div class="row clearfix">
				        <div class="col-sm-12 text-right">
				        	<button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
				        		Save
				        	</button>
				        	<button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
					    </div>
					</div>
	                {!! Form::close()!!}
				</div>
            </div>
        </div>
    </div>
</div>
@endif