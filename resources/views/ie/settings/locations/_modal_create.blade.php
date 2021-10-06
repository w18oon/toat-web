<div id="modal-create-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">

            {!! Form::open(['route' => ['ie.settings.locations.store'], 'class' => 'form-horizontal']) !!}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="m-b-md">
                    <div>Create New Location</div>
                    <div><small>สร้างข้อมูลพื้นที่ใหม่</small></div>
                </h3>
                <hr class="m-b-xs">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>
                                    <div>Name <span class="text-danger">*</span></div>
                                    <div><small>ชื่อ</small></div>
                                </label>
                                {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>
                                    <div>Description <span class="text-danger">*</span></div>
                                    <div><small>รายละเอียด</small></div>
                                </label>
                                {!! Form::text('description', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <label class="col-sm-6 control-label no-padding" style="text-align: left;">
                                    <div>ORG <span class="text-danger">*</span></div>
                                    <div class="m-r-sm"><small>บริษัทที่ใช้งาน</small></div>
                                </label>
                                <div class="col-sm-6">
                                    @foreach($operatingUnits as $ou)
                                    <div><label>
                                        {!! Form::checkbox('accessible_orgs[]', $ou->organization_id , null) !!} {{ $ou->name }}
                                    </label></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-xs-6 control-label no-padding" style="text-align: left;">
                                    <div>Active ?</div>
                                    <div class="m-r-sm"><small>เปิดใช้งาน</small></div>
                                </label>
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                        {!! Form::checkbox('active', true, true,["class"=>"js-switch"] ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix m-t-sm text-right">
                    <div class="col-sm-12">
                        <button class="btn btn-sm btn-primary" type="submit">
                            Create
                        </button>
                        <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            {!! Form::close()!!}

            </div>
        </div>
    </div>
</div>
