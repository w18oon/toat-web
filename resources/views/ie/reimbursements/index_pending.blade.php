@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        Reimbursements : My Pending Activities <br/>
        <small>รายการใบเบิกเงินชดเชยที่คุณกำลังดำเนินการ</small>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>
                Reimbursements : My Pending Activities
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox float-e-margins">
    @include('ie.reimbursements._table')
    @if(isset($reims))
    <div class="m-t-sm text-right">
        {!! $reims->appends($search)->render() !!}
    </div>
    @endif
</div>
@stop