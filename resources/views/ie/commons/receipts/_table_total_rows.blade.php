<tr>
    <td><strong><small>Total Amount <small>before VAT</small> </small></strong></td>
    <td> 
        {{ $parent->total_receipt_amount_before_tax ? number_format($parent->total_receipt_amount_before_tax,2) : '0.00' }} 
        {{ $parentCurrencyId }}
    </td>
</tr>
<tr>
    <td><strong><small>VAT Amount</small></strong></td>
    <td>
        {{ $parent->total_receipt_tax ? number_format($parent->total_receipt_tax,2) : '0.00' }} 
        {{ $parentCurrencyId }}
    </td>
</tr>
<tr>
    <td><strong><small>Total Amount <small>Inc. VAT</small></small></strong></td>
    <td>
        {{ $parent->total_receipt_amount ? number_format($parent->total_receipt_amount,2) : '0.00' }} 
        {{ $parentCurrencyId }}
    </td>
</tr>