@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        Reimbursement <br/>
        <small>ใบเบิกเงินชดเชย</small>
    </h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('ie.reimbursements.index') }}">
                Reimbursements
            </a>
        </li>
        <li class="active">
            <strong>
                {{ $reim->document_no }}
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if($reim->isRequester() && $reim->isNotLock())
    <div class="text-right m-t-lg">
        {{-- BUTTON EDIT --}}
        <button class="btn btn-resize btn-success btn-outline" data-toggle="modal" href="#modal-edit-form">
            <i class="fa fa-edit"></i> Edit
        </button>
        {{-- BUTTON CANCEL --}}
        <div class="btn-resize">
        {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id],
                    'method' => 'POST',
                    'id' => 'form-cancel-request']) !!}

            {!! Form::hidden('activity','CANCEL_REQUEST') !!}
            <button type="submit" class="btn btn-resize btn-danger btn-outline" disabled="disabled">
                <i class="fa fa-ban"></i> Cancel
            </button>

        {!! Form::close() !!}
        </div>
    </div>
    @endif
@stop

@section('content')

    @include('layouts._error_messages')

    <div class="row">
        <div class="col-md-12">
        {{-- ERR MSG OVER BUDGET --}}
        <div id="div_over_budget_err_msg_by_account" class="hide"></div>
        {{-- BLOCKED (UNCLEAR ALERT MESSAGE) --}}
        @if($reim->status == 'BLOCKED')
            @include('ie.commons._unclear_alert_message')
        @endif
        </div>
    </div>

    <div class="row">
        {{-- HEADER DETAIL (DOC# & AMOUNT) --}}
        @include('ie.reimbursements.show._header_detail')
    </div>

    <div class="row">

        <div class="col-md-9">
            <div class="ibox">
                {{-- MAIN DETAIL --}}
                @include('ie.reimbursements.show._main_detail')
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                {{-- ATTACHMENT DETAIL --}}
                @include('ie.reimbursements.show._attachment_detail')
            </div>
        </div>

    </div>

    {{-- RECEIPT TABLE & BUTTON --}}
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                @include('ie.reimbursements.show._receipts')
            </div>
            <div class="ibox">
                <div class="text-right">
                    {{-- REIM REQUEST TRANS BUTTON --}}
                    @include('ie.reimbursements.show._button')
                </div>
            </div>
        </div>
        <div class="col-md-3">
            {{-- APPROVAL DETAIL --}}
            @include('ie.reimbursements.show._approval_detail')
        </div>
    </div>

    {{-- ACTIVITY LOG --}}
    <div class="row">
        <div class="col-md-9 no-padding-xs">
            <div class="ibox-content activity-content mini-scroll-bar m-b-md"
                style="max-height: 400px;overflow: auto;">
                {{-- ACTIVITY LOG --}}
                @include('layouts._activities')
            </div>
        </div>
    </div>

    {{-- MODAL FOR EDIT --}}
    @include('ie.reimbursements._modal_edit')
    {{-- MODAL FOR REIM REQUEST TRANS --}}
    @include('ie.reimbursements.show._modal_approval')

@stop

@section('scripts')

    {{-- SCRIPT REIMBURSEMENT TRANSACTIONS --}}
    @include('ie.reimbursements._script')

        {{-- SCRIPT RECEIPT --}}
    @include('ie.commons.receipts._script')

@stop