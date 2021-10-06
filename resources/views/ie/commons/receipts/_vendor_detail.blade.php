<div class="row m-t-sm m-b-sm">
    <div class="col-md-offset-2 col-md-5 m-b-sm">
        <label for="" class="control-label">Tax ID</label>
        <p class="form-control-static">
            {{ $vendor->tax_id ? $vendor->tax_id : '-' }}
        </p>
    </div>
    <div class="col-md-5">
        <label for="" class="control-label">Branch Name</label>
        <p class="form-control-static">
            {{ $vendor->branch_number ? $vendor->branch_number : '-' }}
        </p>
    </div>
</div>