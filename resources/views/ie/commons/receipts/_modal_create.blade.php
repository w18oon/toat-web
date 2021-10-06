<div id="modal_create_receipt" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-xl" role="document" style="width: 90%; max-width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left" >
                    Add New Receipt <br/>
                    <small>เพิ่มใบเสร็จใหม่</small>
                </h3>
            </div>
            <div class="modal-body">

                <div id="modal_content_create_receipt"> 

                    @include('commons.receipts._form_create')
                            
                </div>

            </div>
        </div>
    </div>
</div>