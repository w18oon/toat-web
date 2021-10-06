<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong>Program Code</strong></div>
        {!! Form::select('program_code', [''=>'-'] + $programCode, $menu->program_code,  ["class" => 'form-control input-md select2 ', "autocomplete" => "off","style"=>"width:100%"]) !!}
    </div>
</div>
<div class="hr-line-dashed"></div>

<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong>Parent Menu </strong></div>
        {!! Form::select('parent_id', [''=>'-'] + $parentMenus , $menu->parent_id,  ["class" => 'form-control input-sm ', "autocomplete" => "off","style"=>"width:100%"]) !!}
    </div>
</div>



<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> Menu Title </strong> <span class="text-danger">*</span></div>
        {!! Form::text('menu_title', old('menu_title', $menu->menu_title), ['class' => 'form-control col-12', 'placeholder' => "", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
    <div class="form-group pl-12 pr-2 mb-0 col-lg-2 col-md-6 col-sm-6 col-xs-6 mt-2">
        <div class="control-label mb-2"><strong> Seq. </strong> <span class="text-danger">*</span></div>
        {!! Form::text('sort_order', old('sort_order', $menu->sort_order), ['class' => 'form-control col-12', 'placeholder' => "", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> url </strong> <span class="text-danger">*</span></div>
        {!! Form::text('url', old('url', $menu->url), ['class' => 'form-control col-12', 'placeholder' => "", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>

    <div class="form-group pl-12 pr-2 mb-0 col-lg-2 col-md-6 col-sm-6 col-xs-6 mt-2">
        <div class="control-label mb-2"><strong> Server </strong> <span class="text-danger">*</span></div>
        {!! Form::select('server_id', $servers , $menu->server_id,  ["class" => 'form-control input-sm ', "autocomplete" => "off","style"=>"width:100%"]) !!}
    </div>
</div>

<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> Permission </strong> <span class="text-danger">*</span></div>
        {!! Form::text('permission_code', old('permission_code', $menu->permission_code), ['class' => 'form-control col-12', 'placeholder' => "", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>

@section('scripts')
@parent
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection