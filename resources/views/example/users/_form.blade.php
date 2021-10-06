
<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> Name </strong> <span class="text-danger">*</span></div>
        {!! Form::text('name', old('name', $user->name), ['class' => 'form-control col-12', 'placeholder' => "USERNAME", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>

<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> <strong> Email </strong> <span class="text-danger">*</span></div>
        {!! Form::email('email', old('email', $user->email), ['class' => 'form-control col-12', 'placeholder' => "USERNAME", 'autocomplete' => "off", 'required' => 'required']) !!}
        <span class="form-text m-b-none">Example block-level help text here.</span>
    </div>
</div>

<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> <strong> Password </strong> <span class="text-danger">*</span></div>
        {!! Form::password('password', ['class' => 'form-control col-12', 'placeholder' => "PASSWORD"]) !!}
    </div>
</div>