<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>รายการคำสั่งการผลิต</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="float-right">
                                    <button type="button" :class="btn_trans.search.class"><i
                                        :class="btn_trans.search.icon"></i>
                                        {{ btn_trans.search.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.closeJob.class"><i
                                        :class="btn_trans.closeJob.icon"></i>
                                        {{ btn_trans.closeJob.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">เลขที่คำสั่งการผลิต:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="form-group row pt-5 pl-3">
                            <div id="close-order"></div>
                            <label class="col-lg-3 col-sm-4 col-form-label">คำสั่งผลิตที่สามารถปิดได้เลย</label>
                        </div>
                        <div class="form-group row pl-3">
                            <div id="not-close-order"></div>
                            <label class="col-lg-3 col-sm-4 col-form-label">คำสั่งผลิตที่ยังไม่สามารถปิดได้เลย</label>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header">
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            เลือก
                                        </div>
                                    </th>
                                    <th class="header" style="min-width: 150px;">เลขที่คำสั่งการผลิต</th>
                                    <th class="header" style="min-width: 150px;">รหัสสินค้าสำเร็จรูป</th>
                                    <th class="header" style="min-width: 250px;">รายละเอียด</th>
                                    <th class="header" style="min-width: 150px;">ประเภทคำสั่งผลิต</th>
                                    <th class="header" style="min-width: 130px;">จำนวนที่สั่งผลิต</th>
                                    <th class="header">หน่วย</th>
                                    <th class="header" style="min-width: 100px;">ผลผลิตที่ได้</th>
                                    <th class="header" style="min-width: 80px;">สถานะคำสั่งผลิต</th>
                                    <th class="header" style="min-width: 100px;">สถานะการบันทึกผลผลิต</th>
                                    <th class="header" style="min-width: 80px;">ตรวจสอบหลังผลิต</th>
                                    <th class="header" style="min-width: 80px;">ตัดใช้วัตถุดิบ</th>
                                    <th class="header" style="min-width: 80px;">รับเข้าคลัง</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="close-order">63-18-06-001</td>
                                    <td class="close-order">100400040</td>
                                    <td class="close-order">TONKA BEAN FLAVOUR</td>
                                    <td class="close-order">สารปรุง, สินค้าทดลอง</td>
                                    <td class="close-order">360</td>
                                    <td class="close-order">KG</td>
                                    <td class="close-order">360</td>
                                    <td class="close-order">ผลิตเสร็จ</td>
                                    <td class="close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       checked disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       checked disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       checked disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       checked disabled>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="not-close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="" disabled="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="not-close-order">63-18-06-002</td>
                                    <td class="not-close-order">100400040</td>
                                    <td class="not-close-order">สารปรุงม สินค้าทดลอง</td>
                                    <td class="not-close-order">TONKA BEAN FLAVOUR</td>
                                    <td class="not-close-order">180</td>
                                    <td class="not-close-order">KG</td>
                                    <td class="not-close-order">140</td>
                                    <td class="not-close-order"></td>
                                    <td class="not-close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="" disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="not-close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="" disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="not-close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="" disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="not-close-order">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="" disabled>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: {
        btn_trans: {type: Object},
    },
}
</script>
<style scoped>
th,
td {
    vertical-align: middle !important;
}

.ibox-title {
    padding: 15px 15px 8px 15px;
}

.check-center {
    text-align: center;
}

th.header {
    text-align: center;
}

td.close-order {
    background: #4ec8af;
}

td.not-close-order {
    background: #fdd790;
}

#close-order {
    background: #4ec8af;
    width: 80px;
}

#not-close-order {
    background: #fdd790;
    width: 80px;
}

.modal-content {
    padding: 15px;
}


</style>
