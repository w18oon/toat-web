@extends('layouts.app')

@section('title', 'Receipt')

@section('page-title')
    <h2>
        Tax Invoice/Receipt # : {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }} <br/>
    </h2>
    <ol class="breadcrumb">
        <li>
        @if($receiptType == 'CLEARING')
            <a href="{{ route('cash-advances.index') }}">Cash Advance</a>
		@elseif($receiptType == 'REIMBURSEMENT') {{-- REIMBURSE --}}
			<a href="{{ route('reimbursements.index') }}">Reimbursement</a>
		@else {{-- INVOICE --}}
            <a href="{{ route('invoices.index') }}">Invoice</a>
        @endif
        </li>
        <li class="active">
        @if($receiptType == 'CLEARING')
            <a href="{{ route('cash-advances.clear',[$parent->id]) }}">{{ $parent->document_no }}</a>
        @elseif($receiptType == 'REIMBURSEMENT') {{-- REIMBURSE --}}
            <a href="{{ route('reimbursements.show',[$parent->id]) }}">{{ $parent->document_no }}</a>
        @else {{-- INVOICE --}}
            <a href="{{ route('invoices.show',[$parent->id]) }}">{{ $parent->document_no }}</a>
        @endif
        </li>
        <li class="active">
        	<strong>Tax Invoice/Receipt # : {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }}</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    {{-- ######### EDIT ######## --}}
    {{-- <div class="text-right m-t-lg">
        <button class="btn btn-success btn-outline" data-toggle="modal" href="#modal-edit-form">
            <i class="fa fa-edit"></i> Edit
        </button>
    </div> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-9" style="padding-right: 2px;">
            <div class="ibox">
                {{-- MAIN DETAIL --}}
                @include('commons.receipts.show._main_detail')
            </div>
            <div class="ibox">
                {{-- TABLE RECEIPT LINES --}}
                <div class="table-responsive m-t" style="font-size: 1em;">
                    @include('commons.receipts.lines._table')
                </div>
                @include('commons.receipts.lines._table_total')
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                {{-- OTHER DETAIL --}}
                @include('commons.receipts.show._other_detail')
            </div>
        </div>
    </div>

    {{-- MODAL CREATE RECEIPT LINE --}}
    {{-- @include('commons.receipts.lines._modal_create') --}}

    {{-- MODAL SHOW RECEIPT LINE --}}
    @include('commons.receipts.lines._modal_show')

@stop

@section('scripts')

    {{-- SCRIPT RECEIPT SHOW PAGE --}}
    @include('commons.receipts.show._script')

@stop