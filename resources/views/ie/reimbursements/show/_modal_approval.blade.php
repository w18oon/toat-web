
{{-- ################################## --}}
{{-- ####### MODAL REIM REQUEST ####### --}}
{{-- ################################## --}}

<div class="text-left">

@if($reim->status == 'NEW_REQUEST' && $reim->isRequester() && $reim->isNotLock())

    {{-- SEND REQUET WITH REASON --}}
    <div class="modal fade" id="modal-send-request-with-reason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Send Request</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" disabled="disabled">Send Request</button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endif

@if($reim->status == 'BLOCKED' && \Auth::user()->isUnblocker())

    {{-- UNBLOCK REQUEST  --}}
    <div class="modal fade" id="modal-unblock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-content">

            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id], 
                'method' => 'POST',
                'id' => 'form-unblock',
                'class' => 'form-horizontal']) !!}

                {!! Form::hidden('activity','UNBLOCK') !!}

                <div class="modal-body">
                    <div class="clearfix m-b-sm text-center">
                        <h1>Unblock Request ?</h1>
                        <h2><span style="font-size: 18px">Please enter reason to Unblock request.</span></h2>
                    </div>
                    <div class="clearfix">
                        <label>Reason (เหตุผลประกอบ) <span class="text-danger">*</span></label>
                        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-warning">Unblock</button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}

            </div>
        </div>
    </div>
@endif

@if($reim->status == 'APPROVER_DECISION' && $reim->isNextApprover())

    {{-- MODAL APPROVER APPROVE --}}
    <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-content">

            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id], 
                'method' => 'POST',
                'id' => 'form-approver-approve',
                'class' => 'form-horizontal']) !!}

                {!! Form::hidden('activity','APPROVER_APPROVE') !!}

                <div class="modal-body">
                    <div class="clearfix m-b-sm text-center">
                        <h1>Approve Request ?</h1>
                        <h2><span style="font-size: 18px">Are you sure to approve request ?</span></h2>
                    </div>
                    <div class="clearfix">
                        <label>Remark (หมายเหตุ) </label>
                        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:60px;"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}

            </div>
        </div>
    </div>

    {{-- MODAL APPROVER SENDBACK  --}}
    <div class="modal fade" id="send-back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-content">

            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id], 
                'method' => 'POST',
                'id' => 'form-approver-send-back',
                'class' => 'form-horizontal']) !!}

                {!! Form::hidden('activity','APPROVER_SENDBACK') !!}

                <div class="modal-body">
                    <div class="clearfix m-b-sm text-center">
                        <h1>Send Back Request ?</h1>
                        <h2><span style="font-size: 18px">Please enter reason to send back request.</span></h2>
                    </div>
                    <div class="clearfix">
                        <label>Reason (เหตุผลประกอบ) <span class="text-danger">*</span></label>
                        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-warning">Send Back</button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}

            </div>
        </div>
    </div>

    {{-- MODAL APPROVER REJECT --}}
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-content">

            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id], 
                  'method' => 'POST',
                  'id' => 'form-approver-reject',
                  'class' => 'form-horizontal']) !!}

                {!! Form::hidden('activity','APPROVER_REJECT') !!}

                <div class="modal-body">
                    <div class="clearfix m-b-sm text-center">
                        <h1>Reject Request ?</h1>
                        <h2><span style="font-size: 18px">Please enter reason to reject request.</span></h2>
                    </div>
                    <div class="clearfix">
                        <label>Reason (เหตุผลประกอบ) <span class="text-danger">*</span></label>
                        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">Reject the request</button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}

            </div>
        </div>
    </div>
    
@endif

</div>