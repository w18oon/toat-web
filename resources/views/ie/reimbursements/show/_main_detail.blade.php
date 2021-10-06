{{-- SHOW ONLY ON PC SCREEN --}}
<div class="row hidden-xs">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>
                        <small>Requester</small>
                        <small>(ผู้ขอเบิก)</small>
                    </dt>
                    <dd>{{ $reim->user->name }}</dd>

                    <dt>
                        <small>Company</small>
                        <small>(ชื่อบริษัท)</small>
                    </dt>
                    <dd>
                        {{ $reim->user->employee->company_name }}
                    </dd>

                    <dt>
                        <small>Department</small>
                        <small>(ชื่อแผนก)</small>
                    </dt>
                    <dd>
                        {{ $reim->user->employee->department_name }}
                    </dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>
                        <small>Bank Name</small>
                        <small>(ธนาคาร)</small>
                    </dt>
                    <dd>
                        {{ $reim->user->employee->bank_name }}
                    </dd>

                    <dt>
                        <small>Account No.</small>
                        <small>(เลขที่บัญชี)</small>
                    </dt>
                    <dd>
                        {{ $reim->user->employee->bank_account_num }}
                    </dd>

                    <dt>
                        <small>Account Name</small>
                        <small>(ชื่อบัญชี)</small>
                    </dt>
                    <dd>
                        {{ $reim->user->employee->vendor_name }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <dl class="dl-horizontal">
            <dt>
                <small>Purpose</small>
                <small>(วัตถุประสงค์)</small>
            </dt>
            <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                {!! $reim->purpose ? nl2br($reim->purpose) : '-' !!}
            </dd>
        </dl>
    </div>
</div>
<hr class="m-t-sm m-b-sm">
