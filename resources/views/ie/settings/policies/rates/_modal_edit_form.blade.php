{!! Form::model($rate, ['route' => ['ie.settings.policies.rates.update', $category->category_id, $sub_category->sub_category_id, $policy->policy_id, $rate->policy_rate_id], 'class' => 'form-horizontal', 'method' => 'patch','id' => 'form-edit-rate'] ) !!}
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="m-b-md">Edit Rate</h3>
    <hr class="m-b-xs">
    <div class="row clearfix">
        <div class="col-sm-5 b-r">
            <div class="row">
                <div class="col-xs-12 m-b-xs">
                <label>
                    <div>Position <span class="text-danger">*</span></div>
                    <div><small>ตำแหน่ง</small></div>
                </label>
                {!! Form::select('position_po_level', [''=>'Any'] + $positionLists, null , ["class" => 'form-control select2', "autocomplete" => "off","style"=>"width:100%","disabled"=>"disabled"]) !!}
                </div>
                <div class="col-xs-12">
                <label>
                    <div>Location <span class="text-danger">*</span></div>
                    <div><small>พื้นที่</small></div>
                </label>
                {!! Form::select('location_id', [''=>'Any'] + $locationLists, null , ["class" => 'form-control select2', "autocomplete" => "off","style"=>"width:100%","disabled"=>"disabled"]) !!}
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <label>Rate <span class="text-danger">*</span></label>
                    @if($policy->type == 'EXPENSE')
                    <div class="clearfix m-b-sm">
                        <label class="radio-inline">
                            {!! Form::radio('unlimit', false, null) !!}
                            Limit Amount
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('unlimit', true, null) !!}
                            Unlimit Amount
                        </label>
                    </div>
                    @endif
                    <div class="input-group">
                        {!! Form::text('rate', null , ["class" => 'form-control text-right', "autocomplete" => "off"]) !!}
                        <span class="input-group-addon">
                            <span>{{ $baseCurrencyId }}</span>
                            {!! Form::hidden('currency_id', $baseCurrencyId) !!}
                            @if($policy->type == 'EXPENSE')
                            <span>
                             / {{ $sub_category->unit }}
                            @if($sub_category->use_second_unit)
                             / {{ $sub_category->second_unit }}
                            @endif
                            </span>
                            @elseif($policy->type == 'MILEAGE')
                            <span> / {{ $mileageUnitLists[$baseMileageUnit] }}</span>
                            {!! Form::hidden('mileage_unit', $baseMileageUnit) !!}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right m-t-lg">
                    <button class="btn btn-sm btn-primary " type="submit">
                        Save
                    </button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
{!! Form::close()!!}