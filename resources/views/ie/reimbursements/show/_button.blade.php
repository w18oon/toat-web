
{{-- ################################# --}}
{{-- ##### BUTTON REIM REQUEST ##### --}}
{{-- ################################# --}}


@if($reim->status == 'NEW_REQUEST' && $reim->isRequester() && $reim->isNotLock())

    {{-- ######### BUTTON SEND REQUEST ######## --}}

    {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id],
                    'method' => 'POST',
                    'id' => 'form-send-request']) !!}

        {!! Form::hidden('activity','SEND_REQUEST') !!}
        <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
            <i class="fa fa-rss"></i> Send Request
        </button>

    {!! Form::close() !!}

@endif

@if($reim->status == 'BLOCKED' && \Auth::user()->isUnblocker())

    {{-- ######### BUTTON UNBLOCK ######## --}}
    <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#modal-unblock">
        <i class="fa fa-unlock"></i> Unblock
    </button>

@endif


@if($reim->status == 'APPROVER_DECISION' && $reim->isNextApprover())

    {{-- ######### BUTTON APPROVER DECISION ######## --}}
    {{-- <div class="btn-resize">
    {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id],
                    'method' => 'POST',
                    'id' => 'form-approver-approve',
                    'style' => 'display: inline;']) !!}

        {!! Form::hidden('activity','APPROVER_APPROVE') !!}
        <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
            <i class="fa fa-check-square-o"></i> Approve
        </button>

    {!! Form::close() !!}
    </div> --}}

    <button class="btn btn-primary btn-resize" data-toggle="modal" data-target="#approve">
        <i class="fa fa-check-square-o"></i> Approve
    </button>

    <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#send-back">
        <i class="fa fa-reply"></i> Send Back
    </button>

    <button class="btn btn-danger btn-resize" data-toggle="modal" data-target="#reject">
        <i class="fa fa-times"></i> Reject
    </button>

@endif

