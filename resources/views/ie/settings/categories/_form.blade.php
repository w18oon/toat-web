<div class="form-group row">
    <label for="name" class="col-md-2 control-label label-no-padding">
        <div>Name <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>ชื่อ</small></div>
    </label>
    <div class="col-md-3">
    @if(isset($category))
        @if(!$category->isAdvanceOver())
            {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
        @else
            {!! Form::hidden('name', $category->name ) !!}
            <p class="form-control-static">{{ $category->name }}</p>
        @endif
    @else
        {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    @endif
    </div>
    <label for="icon" class="col-md-1 control-label label-no-padding">
        <div>Icon <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>ไอคอน</small></div>
    </label>
    <div class="col-md-3">
        {!! Form::select('icon',[''=>'']+$iconLists , null , ["class" => 'form-control icon-picker', "autocomplete" => "off",'id'=>'ddl_icon']) !!}
    </div>
    <div class="col-md-1">
        <div class="show-xs-only show-sm-only m-t-sm">&nbsp;</div>
        <div id="div_icon" class="text-center text-navy" style="font-size:2em;">
        @if(isset($category))
            @include('layouts._icon',['iconClass'=>$category->icon])
        @endif
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-2 control-label label-no-padding">
        <div>Description <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>รายละเอียด</small></div>
    </label>
    <div class="col-md-8">
        {!! Form::text('description', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    </div>
</div>
<hr>
<div class="form-group row">

    <div class="col-md-6 offset-md-2">
        <button type="submit" class="btn btn-primary" data-disable-with="Processing...">Save</button>
        <a href="{{ route('ie.settings.categories.index') }}" class="btn btn-white">Cancel</a>
    </div>
</div>

@section('scripts')
@parent
    <script>
        $(document).ready(function() {

            $("select[name='icon']").change(function(){
                var icon = $("select[name='icon'] option:selected").val();
                $.ajax({
                    url: "/ie/ajax/icon",
                    data: { icon : icon },
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#div_icon").html('<div class="sk-spinner sk-spinner-wave"  style="height:20px">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>');
                    }
                })
                .done(function(result) {
                    $("#div_icon").html(result);
                });
            });

        });
    </script>
@endsection