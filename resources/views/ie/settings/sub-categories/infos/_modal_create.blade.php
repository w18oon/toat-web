<div id="modal-create-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                {!! Form::open(['route' => ['ie.settings.sub-categories.infos.store',$category->category_id,$sub_category->sub_category_id], 'class' => 'form-horizontal']) !!}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="m-b-md">
                        <div>Create Sub-Category Infomation</div>
                        <div><small>สร้างข้อมูลรายละเอียดของประเภทการเบิกย่อยใหม่</small></div>
                        <span id="progress_modal" class="pull-right hide">
                            @include('layouts._progress_bar',['size'=>'20'])
                        </span>
                    </h3>
                    <hr class="m-b-xs">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                                <div class="row m-t-sm">
                                    <div class="col-sm-6">
                                        <label>
                                            <div>Attribute Name <span class="text-danger">*</span></div>
                                            <div><small>ชื่อแอตทริบิวต์</small></div>
                                        </label>
                                        {!! Form::text('attribute_name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <label>
                                            <div>Form Type <span class="text-danger">*</span> </div>
                                            <div><small>ประเภทข้อมูล</small></div>
                                        </label>
                                        {!! Form::select('form_type', $listFormTypes , null , ["id"=>"ddl_form_type_create","class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-t-sm">
                                    <div class="col-sm-12">
                                        <div>
                                            <label> 
                                                <div>Form Value</div>
                                                <div><small>ข้อมูล</small></div>
                                            </label>
                                            <span class="text-info pull-right"
                                                data-toggle="tooltip" 
                                                data-html="true" 
                                                title="@include('ie.settings.sub-categories.infos._tooltip_form_value')">
                                                <i class="fa fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <div id="div_txt_form_value_create">
                                            {!! Form::text('form_value', null , ["class" => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-sm">
                                    <div class="col-sm-12">
                                        <label>
                                            <div>Purpose</div>
                                            <div><small>จุดประสงค์</small></div>
                                        </label>
                                        {!! Form::text('purpose', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-t-sm">
                                    <div class="col-sm-12">
                                        <div class="checkbox"><label>
                                            {!! Form::checkbox('required', true, null ) !!} required (บังคับกรอก) ?
                                        </label></div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    <div class="row clearfix text-right">
                        <div class="col-sm-12">
                            <button id="btn_create" class="btn btn-sm btn-primary" type="submit">
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