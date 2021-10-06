<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
   <table>
    <thead>
        <tr style="border-bottom: 1px solid #000000;">
            <th>No.</th>
            <th>Document #</th>
            <th>Status</th>
            <th>Requester Name</th>
            <th>Requester Company</th>
            <th>Requester Department</th>
            <th>Requester Bank Name</th>
            <th>Requester Account No.</th>
            <th>Requester Account Name</th>
            <th>Purpose</th>
            <th>Tax Invoice/Receipt #</th>
            <th>Tax Invoice/Receipt Date</th>
            <th>Destination</th>
            {{-- <th>Currency</th>
            <th>Exchange Rate</th> --}}
            <th>Address in Tax Inv.</th>
            <th>Vendor</th>
            <th>Description</th>
            {{-- <th>Project</th>
            <th>Job</th>
            <th>Recharge</th> --}}
            <th>Category</th>
            <th>Sub-Category</th>
            <th>Branch</th>
            <th>Department</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Second Quantity</th>
            <th>Second Unit</th>
            <th>Amount before VAT</th>
            <th>VAT Amount</th>
            <th>Amount Inc. VAT</th>
            <th>Currency</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum = 1; ?>
        @foreach($reims as $reim)
            @foreach($reim->receipts as $receipt)
                @foreach($receipt->lines as $receiptLine)
                    <tr>
                        <td>{{ $rownum }}</td>
                        <td>{{ $reim->document_no }}</td>
                        <td>{{ $reim->status }}</td>
                        <td>{{ $reim->user->name }}</td>
                        <td>{{ $reim->user->employee->company_name }}</td>
                        <td>{{ $reim->user->employee->department_name }}</td>
                        <td>{{ $reim->user->employee->bank_name }}</td>
                        <td>{{ $reim->user->employee->bank_account_num }}</td>
                        <td>{{ $reim->user->employee->vendor_name }}</td>
                        <td>{{ $reim->purpose }}</td>
                        <td>{{ $receipt->receipt_number }}</td>
                        <td>{{ $receipt->receipt_date }}</td>
                        <td>{{ $receipt->location->name }}</td>
                        {{-- <td>{{ $receipt->currency_id }}</td>
                        <td>{{ $receipt->exchange_rate }}</td> --}}
                        <td>{{ array_key_exists($receipt->establishment_id, $establishmentLists) ? $establishmentLists[$receipt->establishment_id] : '' }}</td>
                        <td>
                            @if($receipt->vendor_id)
                                @if($receipt->vendor_id != 'other')
                                    {{ $vendorLists[$receipt->vendor_id] }}
                                @else
                                    @if($receipt->vendor_name)
                                        {{ $receipt->vendor_name }}
                                    @else
                                        None
                                    @endif
                                @endif
                            @else
                                None
                            @endif
                        </td>
                        <td>{{ $receipt->justification }}</td>
                        {{-- <td>{{ array_key_exists($receipt->project, $projectLists) ? $projectLists[$receipt->project] : 'N/A' }}</td>
                        <td>{{ $receipt->job }}</td>
                        <td>{{ array_key_exists($receipt->recharge, $rechargeLists) ? $rechargeLists[$receipt->recharge] : 'N/A' }}</td> --}}
                        <td>{{ $receiptLine->category->name }}</td>
                        <td>{{ $receiptLine->subCategory->name }}</td>
                        <td>{{ array_key_exists($receiptLine->branch_code, $branchLists) ? $branchLists[$receiptLine->branch_code] : '-'  }}</td>
                        <td>{{ array_key_exists($receiptLine->department_code, $departmentLists) ? $departmentLists[$receiptLine->department_code] : '-' }}</td>
                        <td>
                            @if($receiptLine->policy)
                                @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                                    {{ '-' }}
                                @else {{-- EXPENSE --}}
                                    {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                                @endif
                            @else {{-- ACTUAL --}}
                                {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                            @endif
                        </td>
                        <td>
                            @if($receiptLine->policy)
                                @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                                @else {{-- EXPENSE --}}
                                    <span>{{ $receiptLine->subCategory->unit }}</span>
                                @endif
                            @else {{-- ACTUAL --}}
                                <span>{{ $receiptLine->subCategory->unit }}</span>
                            @endif
                        </td>
                        <td>
                            @if($receiptLine->subCategory->use_second_unit)
                                @if($receiptLine->policy)
                                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                                        {{ '-' }}
                                    @else {{-- EXPENSE --}}
                                        {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                                    @endif
                                @else {{-- ACTUAL --}}
                                    {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($receiptLine->subCategory->use_second_unit)
                                @if($receiptLine->policy)
                                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                                    @else {{-- EXPENSE --}}
                                        <span>{{ $receiptLine->subCategory->second_unit }}</span>
                                    @endif
                                @else {{-- ACTUAL --}}
                                    <span>{{ $receiptLine->subCategory->second_unit }}</span>
                                @endif
                            @endif
                        </td>
                        <td>{{ $receiptLine->total_primary_amount ? number_format($receiptLine->total_primary_amount,2) : '0.00' }}</td>
                        <td>{{ $receiptLine->primary_vat_amount ? number_format($receiptLine->primary_vat_amount,2) : '0.00' }}</td>
                        <td>{{ $receiptLine->total_primary_amount_inc_vat ? number_format($receiptLine->total_primary_amount_inc_vat,2) : '0.00' }}</td>
                        <td>{{ $reim->currency_id }}</td>
                    </tr>
                    <?php $rownum++; ?>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
   </table>
</body>
</html>