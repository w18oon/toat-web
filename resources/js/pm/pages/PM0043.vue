<template>
    <div class="row">
<!--                <pre>{{-->
<!--                        JSON.stringify({-->
<!--                            lots,-->
<!--                            header,-->
<!--                        }, null, 2)-->
<!--                    }}</pre>-->
        <div class="col-lg-12">
            <div class="float-right mb-3">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#search-modal">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
                <button type="button" class="btn btn-success" @click.prevent="initData">
                    <i class="fa fa-plus"></i> สร้าง
                </button>
                <button type="button" class="btn btn-primary" @click.prevent="onClickSave('ยังไม่ส่งข้อมูล')" :disabled="disableInput">
                    <i class="fa fa-save (alias)"></i> บันทึก
                </button>
                <button type="button" class="btn btn-primary" @click.prevent="onClickSave('โอนเรียบร้อย')" :disabled="header.additive_header_id == '' || disableInput">
                    <i class="fa fa-check-circle-o"></i> ยืนยันการโอน
                </button>
                <button type="button" class="btn btn-danger" @click.prevent="onClickSave('ยกเลิกการโอน')" :disabled="header.additive_header_id == '' || disableInput">
                    <i class="fa fa-check-times"></i> ยกเลิกการโอน
                </button>
                <button type="button" class="btn btn-info">
                    <i class="fa fa-print"></i> พิมพ์
                </button>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>โอนสินค้าสำเร็จรูป</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">หน่วยงาน:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" v-model="header.department_desc" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">วันที่ส่งผลผลิต:</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" :min="sysdate" v-model="header.transfer_date" autocomplete="off" :disabled="disableInput">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">คลังต้นทาง:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" v-model="header.subinventory_from" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">คลังจัดเก็บ:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" v-model="header.subinventory_to" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ใบส่งเลขที่:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="header.transfer_number" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">สถานะ:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="header.status" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"> สถานที่จัดเก็บของคลังต้นทาง:<span style="color: red">*</span></label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <el-select
                                                v-model="header.locator_id_from"
                                                clearable
                                                filterable
                                                remote
                                                placeholder="เลือกสถานที่จัดเก็บ"
                                                @change="onChangeLocator($event, 'locator_from')"
                                                :disabled="disableInput">
                                                <el-option
                                                    v-for="locator in filterLocator(header.subinventory_from)"
                                                    :key="locator.inventory_location_id"
                                                    :label="locator.locator_description"
                                                    :value="locator.inventory_location_id" ></el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.locator_from" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"> สถานที่จัดเก็บของคลังจัดเก็บ:<span style="color: red">*</span></label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <el-select
                                                v-model="header.locator_id_to"
                                                clearable
                                                filterable
                                                remote
                                                placeholder="เลือกสถานที่จัดเก็บ"
                                                @change="onChangeLocator($event, 'locator_to')"
                                                :disabled="disableInput">
                                                <el-option
                                                    v-for="locator in filterLocator(header.subinventory_to)"
                                                    :key="locator.inventory_location_id"
                                                    :label="locator.locator_description"
                                                    :value="locator.inventory_location_id" ></el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.locator_to"  disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right mb-3">
                <div class="text-right">
                    <button type="button" class="btn btn-success" @click.prevent="onClickAddLine()" :disabled="disableInput">
                        <i class="fa fa-plus"></i> เพิ่มรายการ
                    </button>
                    <button type="button" class="btn btn-danger" @click.prevent="onClickDeleteLine()" :disabled="disableInput">
                        <i class="fa fa-times" aria-hidden="true"></i> ลบรายการ
                    </button>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" @click="onClickCheckedAll()" v-model="isCheckedAll" :disabled="disableInput">
                                    </th>
                                    <th>รหัสสินค้าสำเร็จรูป</th>
                                    <th style="min-width: 150px;">รายละเอียด</th>
                                    <th>Lot No. <span style="color: red">*</span></th>
                                    <th>คงคลัง</th>
                                    <th>จำนวน <span style="color: red">*</span></th>
                                    <th>หน่วยนับ</th>
                                    <th>วันที่ผลิต</th>
                                    <th>วันหมดอายุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(line, index) in lines" :key="index">
                                    <td>
                                        <input type="checkbox" v-model="checkedItem" :value="index" @change="onChangeChecked" :disabled="disableInput">
                                    </td>
                                    <td>
                                        <el-select
                                            v-model="line.item_code"
                                            clearable
                                            filterable
                                            remote
                                            placeholder="เลือกรหัสวัตถุดิบ"
                                            @change="onChangeCode($event, index)"
                                            :disabled="disableInput">
                                            <el-option
                                                v-for="code in codes"
                                                :key="code.item_number"
                                                :label="code.item_number"
                                                :value="code.item_number" ></el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="line.item_description" disabled>
                                    </td>
                                    <td>
                                        <!-- <input type="text" class="form-control" v-model="line.lot_number"> -->
                                        <el-select
                                            v-model="line.lot_number"
                                            clearable
                                            filterable
                                            remote
                                            placeholder="เลือก Lot No."
                                            @change="onChangeLot($event, index, line.item_code)"
                                            :disabled="line.item_code == '' || disableInput">
                                            <el-option
                                                v-for="(lot, lotIdx) in filterLot(line.item_code, header.locator_id_from)"
                                                :key="lot.lotIdx"
                                                :label="lot.lot_number"
                                                :value="lot.lot_number" ></el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="line.onhand_qty" disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="line.qty" min="0" @change="onChangeQty(index)" :disabled="disableInput">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="line.uom" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="line.origination_date" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="line.expire_date" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="vuemodal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">ใบส่งเลขที่:</label>
                                    <div class="col-lg-8">
                                        <el-select
                                            v-model="qHeaderId"
                                            clearable
                                            filterable
                                            remote
                                            placeholder="เลือกใบส่งเลขที่">
                                            <el-option
                                                v-for="header in headers"
                                                :key="header.additive_header_id"
                                                :label="header.transfer_number"
                                                :value="header.additive_header_id"></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">วันที่ส่งผลผลิต:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" v-model="qDateForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">สถานะ:</label>
                                    <div class="col-lg-8">
                                        <el-select
                                            v-model="qStatus"
                                            clearable
                                            filterable
                                            remote
                                            placeholder="เลือกสถานะ">
                                            <el-option
                                                v-for="status in listStatus"
                                                :key="status"
                                                :label="status"
                                                :value="status"></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">ถึง:</label>
                                    <div class="col-lg-8">
                                        <input type="date"
                                               class="form-control"
                                               v-model="qDateTo"
                                               :min="qDateForm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button"
                                    class="btn btn-w-m btn-default"
                                    @click.prevent="onClickResetBtn">
                                <i class="fa fa-refresh"></i> ล้างค่า
                            </button>
                            <button type="button"
                                    class="btn btn-default"
                                    @click.prevent="onClickSearch">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>

<!--                        <div class="text-right mb-3">-->
<!--                            <button type="button" class="btn btn-default" @click.prevent="onClickSearch">-->
<!--                                <i class="fa fa-search"></i> ค้นหา-->
<!--                            </button>-->
<!--                        </div>-->
                        <div style="height: 300px; overflow: scroll;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบส่ง</th>
                                        <th>วันที่ส่งผลผลิต</th>
                                        <th>สถานะ</th>
                                        <th>สถานที่จัดเก็บของคลังต้นทาง</th>
                                        <th>สถานที่จัดเก็บของคลังจัดเก็บ</th>
                                    </tr>
                                </thead>
                                <tbody v-if="resultHeaders.length">
                                    <tr v-for="header in resultHeaders" :key="header.additive_header_id" style="cursor: pointer" @click="onClickHeader(header.additive_header_id)">
                                        <td>{{ header.transfer_number }}</td>
                                        <td>{{ header.transfer_date }}</td>
                                        <td>{{ header.status }}</td>
                                        <td>{{ getLocator(header.locator_id_from) }}</td>
                                        <td>{{ getLocator(header.locator_id_to) }}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5">ไม่พบข้อมูล</td>
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
import {
    showLoadingDialog,
    showValidationFailedDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
    showRemoveLineConfirmationDialog,
} from "../../commonDialogs"

export default {
    props: ['sysdate', 'department_code', 'department_desc', 'props_headers', 'locators', 'codes', 'lots'],
    mounted() {
        this.initData()
    },
    data() {
        return {
            headers: this.props_headers,
            resultHeaders: [],
            header: '',
            lines: [],
            listStatus: ['ยังไม่ส่งข้อมูล', 'โอนเรียบร้อย', 'ยกเลิกการโอน'],
            qHeaderId: '',
            qStatus: '',
            qDateForm: '',
            qDateTo: '',
            isCheckedAll: false,
            checkedItem: [],
        }
    },
    computed: {
        disableInput() {
            return (this.header.status == 'โอนเรียบร้อย' || this.header.status == 'ยกเลิกการโอน')
        },
    },
    methods: {
        initData() {
            this.header = {
                additive_header_id: '',
                department_code: this.department_code,
                department_desc: this.department_desc,
                transfer_number: '',
                transfer_date: this.sysdate,
                status: '',
                subinventory_from: 'RESBKK01',
                locator_id_from: '',
                locator_from: '',
                subinventory_to: 'PURBKK20',
                locator_id_to: '',
                locator_to: '',
                program_id: 'PMP0038',
                web_batch_no: '',
                interfac_msg: '',
                record_status: '',
                transaction_flag: '',
            }
            this.lines = []
        },
        onClickResetBtn() {
            this.qHeaderId = ''
            this.qStatus = ''
            this.qDateForm = ''
            this.qDateTo = ''
        },
        onClickSearch() {
            this.resultHeaders = []
            this.resultHeaders = this.filterHeadersById(this.filterHeadersByStatus(this.filterHeadersByDateFrom(this.filterHeadersByDateTo(this.headers))))
        },
        filterHeadersById(headers) {
            if (!this.qHeaderId) return headers
            return headers.filter(header => header.additive_header_id == this.qHeaderId)
        },
        filterHeadersByStatus(headers) {
            if (!this.qStatus) return headers
            return headers.filter(header => header.status == this.qStatus)
        },
        filterHeadersByDateFrom(headers) {
            if (!this.qDateForm) return headers
            return headers.filter(header => new Date(header.transfer_date).getTime() >= new Date(this.qDateForm).getTime())
        },
        filterHeadersByDateTo(headers) {
            if (!this.qDateTo) return headers
            return headers.filter(header => new Date(header.transfer_date).getTime() <= new Date(this.qDateTo).getTime())
        },
        getLocator(locatorId) {
            return this.locators.filter(locator => locator.inventory_location_id == locatorId)[0]['locator_description']
        },
        onClickHeader(headerId) {
            showLoadingDialog()
            axios.get('/api/pm/0043/' + headerId).then(response => {
                if (response.status == 200) {
                    swal.close()
                    console.log('response', response.data)

                    console.log('headers', this.headers)

                    console.log('setData ..')

                    this.setData(response.data)

                    console.log('headers', this.headers)

                }
            }).catch(error => {
                console.log(error)
            })
            $('#search-modal').modal('hide')
            this.resultHeaders = []
            this.qHeaderId = ''
            this.qStatus = ''
            this.qDateForm = ''
            this.qDateTo = ''
        },
        onClickAddLine() {
            this.lines.push({
                additive_line_id: '',
                organization_id: '',
                inventory_item_id: '',
                item_code: '',
                item_description: '',
                lot_number: '',
                onhand_qty: '',
                qty: '',
                uom: '',
                origination_date: '',
                expire_date: '',
            })
        },
        onClickCheckedAll() {
            this.checkedItem = []
            if (!this.isCheckedAll) {
                this.lines.forEach((line, index) => { this.checkedItem.push(parseInt(index)) })
            }
        },
        onChangeChecked() {
            this.isCheckedAll = (this.checkedItem.length == this.lines.length)
        },
        onClickDeleteLine() {
            showRemoveLineConfirmationDialog(this.checkedItem.length).then(result => {
                if (result) {
                    let removeId = []
                    this.checkedItem.forEach(item => {
                        if(this.lines[item].additive_line_id != '') {
                            removeId.push(this.lines[item].additive_line_id)
                        }
                    })

                    if(removeId.length > 0){
                        console.log('call api for delete item from db')
                        axios.delete('/api/pm/0043', {
                            params: {
                                id: removeId,
                            }
                        }).then(response => {
                            if (response.status == 200) {
                                console.log(response)
                            }
                        }).catch(error => {
                            console.log(error)
                        })
                    }

                    this.checkedItem.sort((a,b) => { return b-a })

                    // loop for remove checked from array
                    this.checkedItem.forEach(item => { this.lines.splice(item, 1) })

                    // clear checked
                    this.checkedItem = []
                    if (this.isCheckedAll) {
                        this.isCheckedAll = !this.isCheckedAll
                    }
                }
            })
        },
        onChangeCode(ev, idx) {
            let code = this.codes.filter(code => code.item_number == ev)[0]
            this.lines[idx].item_description = (code)? code.item_desc: ''
            this.lines[idx].lot_number = ''
            this.lines[idx].onhand_qty = ''
            this.lines[idx].qty = ''
            this.lines[idx].uom = ''
            this.lines[idx].origination_date = ''
            this.lines[idx].expire_date = ''
        },
        filterLot(code, locatorId) {
            // if (!code) return this.lots
            return this.lots.filter(lot => lot.item_number == code && lot.locator_id == locatorId)
            //this.lots = this.lots.filter(lot => lot.item_number == code && lot.locator_id == locatorId)
        },
        onChangeLot(ev, idx, itemCode) {
            let lot = this.lots.filter(lot => lot.lot_number == ev && lot.item_number == itemCode)[0]
            this.lines[idx].organization_id = (lot)? lot.organization_id: ''
            this.lines[idx].inventory_item_id = (lot)? lot.inventory_item_id: ''
            this.lines[idx].onhand_qty = (lot)? lot.onhand_quantity: ''
            this.lines[idx].uom = (lot)? lot.primary_uom_code: ''
            this.lines[idx].origination_date = (lot)? lot.origination_date: ''
            this.lines[idx].expire_date = (lot)? lot.expiration_date: ''
        },
        onChangeQty(idx) {
            if(parseFloat(this.lines[idx].qty) > parseFloat(this.lines[idx].onhand_qty)) {
                this.lines[idx].qty = this.lines[idx].onhand_qty
            }
            if(parseFloat(this.lines[idx].qty) < 0) {
                this.lines[idx].qty = 0
            }
        },
        filterLocator(subinventoryName) {
            return this.locators.filter(locator => locator.subinventory_name == subinventoryName)
        },
        onChangeLocator(ev, targetAttr) {
            let locator = this.locators.filter(locator => locator.inventory_location_id == ev)
            this.header[targetAttr] = locator[0].locator_name
        },
        validate() {
            let errors = []
            if (!this.header.locator_id_from) {
                errors.push('สถานที่จัดเก็บของคลังต้นทาง')
            }

            if (!this.header.locator_id_to) {
                errors.push('สถานที่จัดเก็บของคลังจัดเก็บ')
            }

            if(this.lines.length > 0) {
                this.lines.forEach(function(line) {
                    if (!line.lot_number) {
                        errors.push('Lot No.')
                    }
                    if (!line.qty) {
                        errors.push('จำนวน')
                    }
                })
            }

            if(errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        onClickSave(status) {
            if(!this.validate()) {
                return;
            }

            let params = {
                header: this.header,
                lines: this.lines,
                status: status
            }

            showLoadingDialog()

            if(this.header.additive_header_id) {
                // UPDATE
                axios.put('/api/pm/0043/' + this.header.additive_header_id, params).then(response => {
                    if (response.status == 200) {
                        if(response.data.err_msg != '') {
                            showGenericFailureDialog(response.data.err_msg)
                        }
                        showSaveSuccessDialog()
                        this.setData(response.data)
                        console.log(response)
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            } else {
                // CREATE
                axios.post('/api/pm/0043', params).then(response => {
                    if (response.status == 200) {
                        showSaveSuccessDialog()
                        this.setData(response.data)

                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            }
        },
        setData(data) {
            this.resultHeaders = []
            this.headers = data.headers
            this.header = data.header
            this.lines = data.lines
        },
    }
}
function toDateFormatString(d) {
    let month = `${d.getMonth() + 1}`
    let date = `${d.getDate()}`
    return `${d.getFullYear()}-${month.padStart(2, '0')}-${date.padStart(2, '0')}`
}

</script>
