<script type="text/javascript">

	$(document).ready(function(){

        var screenWidth = $(document).width();
        // ADD CLASS 'mini-navbar' ONLY FOR PC SCREEN
        if(screenWidth > 767){
            $("body").addClass('mini-navbar');
        }

        // EVENT SHOW RECEIPT LINE INFORMATIONS
        $("[id^='button_show_receipt_line_']").click(function(){
            var receiptId = $(this).attr('data-receipt-id');
            var receiptLineId = $(this).attr('data-receipt-line-id');
            $("#modal_show_receipt_line").modal('show');
            renderShowReceiptLineInformations(receiptId,receiptLineId);
        });

        function renderShowReceiptLineInformations(receiptId, receiptLineId)
        {
            $.ajax({
                url: "{{ url('/') }}/receipts/"+receiptId+"/lines/"+receiptLineId+"/get_show_infos",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId }, 
                beforeSend: function( xhr ) {
                    $("#modal_content_show_receipt_line").html('\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>');
                }
            })
            .done(function(result) {
                $("#modal_content_show_receipt_line").html(result);
            });
        }

	});

</script>