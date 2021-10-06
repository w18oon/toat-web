{!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->id],
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'id' => 'form-send-request-with-reason',
    'class' => 'form-horizontal']) !!}

    {!! Form::hidden('activity','SEND_REQUEST') !!}

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Request</h4>
    </div>
    <div class="modal-body">
        <div class="clearfix m-b-sm">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="text-warning">
                        <i class="fa fa-exclamation-triangle"></i> {{ $title }}
                    </h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-right" style="font-size: 12px">
                        <span id="attachmentDescSendRequest" class="hide">
                            <span id="attachmentDescTextSendRequest" class="m-r-xs"></span>
                            <span id="btnCancelFileSendRequest" class="btn btn-xs btn-danger btn-outline"
                                style="font-size: 12px">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                        <span id="btnAddFileSendRequest"
                            class="fileUpload btn btn-xs btn-primary btn-outline"
                            style="font-size: 12px">
                            <i class="fa fa-plus"></i> Attach File
                            <input id="inputAttachmentSendRequest" name="file" type="file" class="upload" />
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-mute">&emsp;&emsp;{!! $text !!}</p>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <label>Reason (เหตุผลประกอบ) <span class="text-danger">*</span></label>
            {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Send Request</button>
        <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
    </div>
{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function(){
        // ADD ATTACHMENT
        $("#inputAttachmentSendRequest").change(function(){
            if(this.value){
                let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                $("#attachmentDescTextSendRequest").text(filename);
                $("#attachmentDescSendRequest").removeClass("hide");
                $("#btnAddFileSendRequest").addClass("hide");
            }else{
                $("#attachmentDescTextSendRequest").text("");
                $("#attachmentDescSendRequest").addClass("hide");
                $("#btnAddFileSendRequest").removeClass("hide");
            }
        });

        // CANCEL ATTACHMENT
        $("#btnCancelFileSendRequest").click(function(){
            $("#inputAttachmentSendRequest").val('');
            $("#attachmentDescTextSendRequest").text("");
            $("#attachmentDescSendRequest").addClass("hide");
            $("#btnAddFileSendRequest").removeClass("hide");
        });

    });
</script>