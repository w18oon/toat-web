{!! Form::open(['route' => ['ie.settings.policies.store', [$category->category_id, $sub_category->sub_category_id]], 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('type', $type) !!}
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="m-b-md">
        @if($type == 'EXPENSE')
            Use Expense Policy <br>
            <small>ใช้งานการเบิกค่าใช้จ่าย</small>
        @else  {{-- MILEAGE --}}
            Use Mileage Policy <br>
            <small>ใช้งานการเบิกเงินตามระยะทาง</small>
        @endif
    </h3>
    <hr class="m-b-xs">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="m-t-sm">
                <label>
                    Default Rate <small class="text-mute">( for any case )</small>
                    <span class="text-danger">*</span>
                </label>
                @if($type == 'EXPENSE')
                <div class="clearfix m-b-sm">
                    <label class="radio-inline">
                        {!! Form::radio('unlimit', false, true) !!}
                        Limit Amount
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('unlimit', true, false) !!}
                        Unlimit Amount
                    </label>
                </div>
                @endif
                <div class="input-group">
                    {!! Form::text('rate', null , ["class" => 'form-control text-right', "autocomplete" => "off"]) !!}
                    <span class="input-group-addon">
                        <span>{{ $baseCurrencyId }}</span>
                        {!! Form::hidden('currency_id', $baseCurrencyId) !!}
                        @if($type == 'EXPENSE')
                        <span>
                         / {{ $sub_category->unit }}
                        @if($sub_category->use_second_unit)
                         / {{ $sub_category->second_unit }}
                        @endif
                        </span>
                        @elseif($type == 'MILEAGE')
                        <span> / {{ $mileageUnitLists[$baseMileageUnit] }}</span>
                        {!! Form::hidden('mileage_unit', $baseMileageUnit) !!}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix m-t-lg text-right">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-sm btn-primary" data-disable-with="Saving...">
                Save
            </button>
            <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">

    $(document).ready(function(){

        $('input[name="unlimit"]').change(function(){

            let unlimit = $(this).val();
            if(unlimit){
                $("input[name='rate']").attr('disabled','disabled');
                $("input[name='rate']").val('Unlimit');
            }else{
                $("input[name='rate']").removeAttr('disabled');
                $("input[name='rate']").val('');
            }

        });

    });

</script>