@if($formType == 'text')
	{!! Form::text('form_value', null , ["class" => 'form-control']) !!}
@elseif($formType == 'select')
	{!! Form::text('form_value', null , ["class" => 'form-control tagsinput']) !!}
@elseif($formType == 'date')
	{!! Form::text('form_value', null , ["class" => 'form-control date-picker']) !!}
@endif

<script>
    $(document).ready(function(){

    	$('.tagsinput').tagsinput({
            tagClass: 'label label-primary'
        });

        $('.date-picker').datepicker({
            format: "{{ trans('date.js-format') }}",
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $("input[name='form_value'],div.bootstrap-tagsinput > input").keydown(function(e){
            var code = e.keyCode || e.which;
            if (code == '13'){ e.preventDefault(); }
        });
        
    });
</script>