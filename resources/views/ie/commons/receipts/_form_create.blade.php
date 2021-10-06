{!! Form::open(['route' => ['receipts.store'],
                    'method' => 'POST',
                    'id' => 'form-create-receipt',
                    'class' => 'form-horizontal']) !!}

    <div class="row">
        <div class="col-md-9 b-r">
            <div class="mini-scroll-bar" style="max-height: 480px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">

                {!! Form::hidden('receipt_type',$receiptType) !!}
                {!! Form::hidden('receipt_parent_id',$receiptParentId) !!}
                {{-- {!! Form::hidden('base_currency_id',$baseCurrencyId) !!} --}}

                {{-- Receipt No --}}
                <div class="row m-b-sm">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        <div><small>Receipt #</small>
                            <span class="text-danger">*</span>
                        </div>
                        <div><small>เลขที่ใบเสร็จ</small></div>
                    </label>
                    <div class="col-md-4">
                        {!! Form::text('receipt_number', null, ['class'=>'form-control input-sm','id'=>'txt_receipt_number']) !!}
                        <div class="text-danger">
                            {{-- <small>กรณีไม่มีใบเสร็จ ให้ใส่ N/A <br> In case of no document, please input N/A</small> --}}
                        </div>
                    </div>
                    <label for="" class="col-md-1 control-label label-no-padding">
                        <div>Date
                            <span class="text-danger">*</span>
                        </div>
                        <div><small>วันที่ใช้บริการ</small></div>
                    </label>
                    <div class="col-md-5">
                        {!! Form::text('receipt_date', null, ['class'=>'form-control input-sm','id'=>'txt_receipt_date']) !!}
                    </div>
                </div>

                <div class="hr-line-dashed m-t-sm m-b-sm"></div>

                <div class="row">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        <div>Location
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>พื้นที่ใช้บริการ</small></div>
                    </label>
                    <div class="col-md-4">
                        {!! Form::select('location_id', $locationLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:12px;width:100%" , 'id'=>'ddl_location_id']) !!}
                    </div>
                    <label for="" class="col-md-1 control-label label-no-padding">
                        <div><small>Currency</small>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>สกุลเงิน</small></div>
                    </label>
                    <div class="col-md-5">
                        <div class="row">
                            {{-- Currency --}}
                            <div class="col-md-4">
                                {!! Form::select('currency_id',$currencyLists,$parentCurrencyId,['class'=>'form-control input-sm', "autocomplete" => "off", 'id'=>'ddl_currency_id', "style"=>"font-size:12px;width:100%"]) !!}
                            </div>
                            {{-- Exchange Rate --}}
                            <div class="col-md-8">
                                <label class="control-label no-padding show-sm-only show-xs-only" style="text-align: left;">
                                    <div><small>Exchange Rate</small></div>
                                    <div class="m-r-sm"><small>อัตราแลกเปลี่ยน</small></div>
                                </label>
                                {!! Form::text('exchange_rate', null, ['class'=>'form-control input-sm', "autocomplete" => "off", 'placeholder' => 'Exchange Rate', 'id'=>'txt_exchange_rate']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @if(count($locations) > 0)
                <div class="row m-b-sm">
                    <div class="col-md-10 col-md-offset-2">
                        <small>
                        @foreach($locations as $location)
                            <strong>{{ $location->name }}</strong> : {{ $location->description }} <br>
                        @endforeach
                        </small>
                    </div>
                </div>
                @endif --}}

                {{-- USE ONLY REIMBURSEMENT & CLEARING --}}
                @if($receiptType == 'REIMBURSEMENT' || $receiptType == 'CLEARING')

                <div class="hr-line-dashed m-t-sm m-b-sm"></div>

                <div class="row m-b-sm">
                    <div class="col-md-6">
                        {{-- Establishment --}}
                        <div class="row">
                            <label for="" class="col-md-4 control-label label-no-padding">
                                {{-- TMITH Branch <span class="text-danger">*</span> --}}
                                <div>
                                    <small>Address in Tax Inv.</small>
                                    <span class="text-danger">*</span>
                                </div>
                                <div class="m-r-sm">
                                    <small>ที่อยู่ในใบกำกับภาษี</small>
                                </div>
                            </label>
                            <div class="col-md-8">
                                {!! Form::select('establishment_id', $establishmentLists ,$defaultEstablishmentId, ['class'=>'form-control input-sm', "autocomplete" => "off" , 'id'=>'ddl_establishment_id',"style"=>"font-size:12px;width:100%"]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- Vendor --}}
                        <div class="row">
                            <label for="" class="col-md-2 control-label label-no-padding">
                                <div>Vendor
                                    {{-- <span class="text-danger">*</span> --}}
                                </div>
                                <div><small>ผู้ให้บริการ</small></div>
                            </label>
                            <div class="col-md-10">
                                {!! Form::select('vendor_id', [''=>'None','other'=>'Other'] + $vendorLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%" , 'id'=>'ddl_vendor_id']) !!}
                            </div>
                        </div>
                        <div class="m-t-sm" id="showOtherVendor" style="display: none;">
                            <div class="row m-b-sm">
                                <div class="col-md-10 col-md-offset-2">
                                    {!! Form::text('vendor_name', null, ['class'=>'form-control input-sm', 'placeholder' => 'Vendor Name', 'id'=>'txt_vendor_name']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-md-offset-2 m-b-sm">
                                    {!! Form::text('vendor_tax_id', null, ['class'=>'form-control input-sm', 'placeholder' => 'Tax ID', 'id'=>'txt_vendor_tax_id']) !!}
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('vendor_branch_name', null, ['class'=>'form-control input-sm', 'placeholder' => 'Branch Number', 'id'=>'txt_vendor_branch_name']) !!}
                                </div>
                            </div>
                        </div>
                        <div id="div_oracle_vendor_detail">

                        </div>
                        {{-- <div class="col-sm-offset-2 col-sm-10 text-danger">
                            <div class="row">
                                <small> * จำเป็นต้องกรอกหากมีการคิดภาษีมูลค่าเพิ่ม <br> required if amount including vat</small>
                            </div>
                        </div> --}}
                    </div>
                </div>

                @endif

                <div class="hr-line-dashed m-t-sm m-b-sm"></div>

                {{-- Jusification --}}
                <div class="row m-b-sm">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        {{-- Description <span class="text-danger">*</span> --}}
                        <div>Description
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>รายละเอียด</small></div>
                    </label>
                    <div class="col-md-10">
                        {{-- <textarea name="" id="" rows="3" class="form-control input-sm"></textarea> --}}
                        {!! Form::textArea('jusification', null, ['class'=>'form-control input-sm', "autocomplete" => "off" , 'id'=>'txt_jusification','rows'=>"4"]) !!}
                    </div>
                </div>

                {{-- <div class="hr-line-dashed m-t-sm m-b-sm"></div> --}}

                {{-- Project --}}
                <div class="row hide">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        {{-- Project <span class="text-danger">*</span> --}}
                        <div>Project
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>โครงการ</small></div>
                    </label>
                    <div class="col-md-10">
                        {{-- {!! Form::text('project', null, ['class'=>'form-control input-sm', "autocomplete" => "off", 'placeholder' => 'Project', 'id'=>'txt_project']) !!} --}}
                        {!! Form::select('project', $projectLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%", 'id'=>'ddl_project']) !!}
                        <div><ul>
                            <li>
                            <small>
                            ให้เลือก project ที่ต้องการบันทึกค่าใช้จ่าย หากไม่มีให้เลือก "N/A(000)" <br>
                            Please select project name, if no please input "N/A(000)"</small>
                            </li>
                        </ul></div>
                    </div>
                </div>
                <div class="row hide">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        {{-- Job <span class="text-danger">*</span> --}}
                        <div>Job
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>งาน</small></div>
                    </label>
                    <div class="col-md-10">
                        {!! Form::text('job', 'N/A', ['class'=>'form-control input-sm', "autocomplete" => "off", 'placeholder' => 'Job', 'id'=>'txt_job']) !!}
                        <div><ul>
                            <li>
                            <small>
                            กรณีที่ค่าใช้จ่ายไม่ไปเรียกเก็บกับบริษัทในเครือ กรุณากรอก  "N/A"<br>
                            In case of the expense is not to be charged to Inter-Company, please put " N/A "</small>
                            </li>
                            <li>
                            <small>
                            กรณีที่ค่าใช้จ่ายไปเรียกเก็บกับบริษัทในเครือ กรุณากรอกตามฟอร์แมตดังนี้<br>(ชื่อของโปรเจค ลีดเดอร์/ ช่วงเวลา (ที่ใช้จ่าย) /ประเทศ เช่น Mr. Bill/ 1-5 Feb 17/ Singapore)<br>
                            In case of the expense is to be charged to Inter-Company, please put information as the following format<br>(Project leader name / Project date / Country), for example: Mr.Bill / 1-5 Feb 17 / Singapore)</small>
                            </li>
                        </ul></div>
                    </div>
                </div>
                <div class="row hide">
                    <label for="" class="col-md-2 control-label label-no-padding">
                        {{-- Recharge <span class="text-danger">*</span> --}}
                        <div>Recharge
                            <span class="text-danger">*</span>
                        </div>
                        <div class="m-r-sm"><small>ชาร์จบริษัท</small></div>
                    </label>
                    <div class="col-md-10">
                        {!! Form::select('recharge', $rechargeLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%", 'id'=>'ddl_recharge']) !!}
                        <div><ul>
                            <li>
                            <small>กรณีที่ค่าใช้จ่ายไม่ไปเรียกเก็บกับบริษัทในเครือ กรุณากรอก  "N/A (00)" <br> In case of the expense is not to be charged to Inter-Company, please select " N/A (00) " </small>
                            </li>
                            <li>
                            <small>กรณีที่ค่าใช้จ่ายไปเรียกเก็บกับบริษัทในเครือ กรุณากรอกชื่อบริษัทในเครือ <br> In case of the expense is to be charged to Inter-Company, please select Inter-Company name</small>
                            </li>
                        </ul></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row m-b-sm">
                <div class="col-sm-12">
                    <label>Attachments (ไฟล์แนบ) </label>
                    <div class="text-center dropzone m-t-xs m-b-xs"
                        id="dropzoneReceiptAttachment">
                        <div class="dz-message p-lg">
                            <div>
                                <i class="fa fa-file-text-o fa-3x"></i>
                            </div>
                            <div class="m-t-md">Drop files or Click</div>
                        </div>
                    </div>
                    <small style="color:#aaa"> Allow: jpeg, png, pdf, doc, docx, xls, xlsx, rar, zip and size < 5mb </small><br>
                    <small style="color:#aaa"> Max files : 2</small>
                </div>
            </div>
        </div>
    </div>

    <div class="hr-line-dashed m-t-sm m-b-sm"></div>

    <div class="text-right">
        <button id="btn_submit_create_receipt" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ..." type="button" class="btn btn-primary">
            Save
        </button>
        <button type="button" class="btn btn-white" data-dismiss="modal">
            Close
        </button>
    </div>

    @include('layouts._dropzone_template')

{!! Form::close() !!}
