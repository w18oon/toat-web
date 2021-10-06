<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>ยืนยันยอดผลผลิตสูญ,สูญเสีย (กันกรอง)</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">เลขที่คำสั่งผลิต <span style="color: red;">*</span>:</label>
                                <div class="col-lg-9">
                                    <el-select 
                                        v-model="header.batch_no" 
                                        filterable 
                                        remote 
                                        placeholder="ระบุเลขที่คำสั่งผลิต" 
                                        :loading="false" 
                                        @change="onChangeLookupHeader">
                                        <el-option 
                                            v-for="lookupHeader in this.headers" 
                                            :key="lookupHeader.batch_no" 
                                            :label="lookupHeader.batch_no" 
                                            :value="lookupHeader.batch_no" >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">สินค้าที่จะผลิต:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.item_code" disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.item_desc" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">จำนวนที่สั่งผลิต:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.request_qty" disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.uom" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">ขั้นตอนการทำงาน<span style="color: red;">*</span>:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <el-select 
                                                v-model="stepCode" 
                                                filterable 
                                                remote 
                                                placeholder="ระบุขั้นตอนการทำงาน" 
                                                :loading="false"
                                                @change="onChangeLookupStep"
                                                :disabled="header.batch_no == ''">
                                                <el-option 
                                                    v-for="step in this.lookupSteps" 
                                                    :key="step.code" 
                                                    :label="step.code" 
                                                    :value="step.code" >
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="stepDesc" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">ประเภทคำสั่งผลิต:</label>
                                <div class="col-lg-9">
                                    <input class="form-control" v-model="header.product_type" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">Blend No.:</label>
                                <div class="col-lg-9">
                                    <input class="form-control" v-model="header.blend_no" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">วันที่เริ่มผลิต:</label>
                                <div class="col-lg-9">
                                    <input class="form-control" v-model="header.start_date" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">ผลผลิตที่ได้:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="header.product_qty" disabled>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" v-model="header.uom" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-right">
                <button type="button" @click.prevent="resetForm" class="btn btn-default"><i class="fa fa-refresh"></i> ล้างค่า</button>
                <button type="button" @click.prevent="saveForm" class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
            </p>
            <div class="ibox">
                <div class="ibox-title">
                    <h3>บันทึกผลผลิตรายวัน</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>วันที่ได้ผลผลิต</th>
                                    <th>คงคลังเช้า</th>
                                    <th>ผลผลิตที่ได้</th>
                                    <th>สูญเสีย</th>
                                    <th>จ่ายออก<span style="color: red;">*</span></th>
                                    <th>คงคลังเย็น(WIP)</th>
                                    <th>หน่วยนับ</th>
                                    <th>ตัดใช้วัตถุดิบ</th>
                                </tr>
                            </thead>
                            <tbody v-if="selectedLines.length">
                                <tr v-for="(line, lineIdx) in selectedLines" :key="lineIdx">
                                    <td>
                                        <a class="text-info" @click.prevent="selectLine(line.batch_id, line.product_date, line.wip_step, lineIdx)">{{ line.product_date }}</a>
                                        <!-- <button 
                                            type="button" 
                                            class="btn btn-w-m btn-link" 
                                            @click.prevent="selectLine(line.batch_id, line.product_date, line.wip_step, lineIdx)">{{ line.product_date }}</button> -->
                                    </td>
                                    <td>{{ line.receive_wip }}</td>
                                    <td>{{ line.product_qty }}</td>
                                    <td>{{ line.loss_qty }}</td>
                                    <td>
                                        <input type="number" 
                                            class="form-control" 
                                            @change="calTransferQty(lineIdx)"
                                            v-model="line.transfer_qty"
                                            :disabled="line.transaction_flag"
                                            min="0"/>
                                    </td>
                                    <td>{{ line.transfer_wip }}</td>
                                    <td>{{ line.uom }}</td>
                                    <td>
                                        <input type="checkbox" v-model="line.transaction_flag" disabled/>
                                        <!-- <input type="checkbox" :disabled="line.transaction_flag == 'Y'" disabled> -->
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8">ไม่มีข้อมูล</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h3>บันทึกผลผลิตรายวันรายเครื่อง {{ displayProdDate }}</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center">
                                    <th rowspan="2">ชุดเครื่องจักร</th>
                                    <th rowspan="2" style="width: 150px;">หมายเลขเครื่องจักร</th>
                                    <th colspan="2">ช่วงเวลา 07.30-11.30</th>
                                    <th colspan="2">ช่วงเวลา 11.30-12.30</th>
                                    <th colspan="2">ช่วงเวลา 12.30-16.30</th>
                                    <th colspan="2">ช่วงเวลา 16.30เป็นต้นไป</th>
                                    <th rowspan="2">ยอดสูญเสียรวมรายวัน</th>
                                    <th rowspan="2">ยืนยันยอดสูญเสีย</th>
                                    <th rowspan="2">ยอดผลผลิตรวมทั้งวัน</th>
                                    <th rowspan="2">หน่วยนับ</th>
                                    <th rowspan="2">ตัดใช้วัตถุดิบ</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr align="center">
                                    <th>ผลผลิตที่ได้</th>
                                    <th>ยืนยันยอดผลผลิต</th>
                                    <th>ผลผลิตที่ได้</th>
                                    <th>ยืนยันยอดผลผลิต</th>
                                    <th>ผลผลิตที่ได้</th>
                                    <th>ยืนยันยอดผลผลิต</th>
                                    <th>ผลผลิตที่ได้</th>
                                    <th>ยืนยันยอดผลผลิต</th>
                                </tr>
                            </thead>
                            <tbody v-if="selectedDistributions.length">
                                <tr v-for="(distribution, distributionIdx) in selectedDistributions" :key="distributionIdx">
                                    <td>{{ distribution.machine_set }}</td>
                                    <td>{{ distribution.machine_number }}</td>
                                    <td>{{ distribution.qty_01 }}</td>
                                    <td><input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="distribution.result_qty_01" 
                                        @change="updProdQty(distributionIdx)"
                                        :disabled="distribution.transaction_flag" 
                                        min="0"/></td>
                                    <td>{{ distribution.qty_02 }}</td>
                                    <td><input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="distribution.result_qty_02"
                                        @change="updProdQty(distributionIdx)"
                                        :disabled="distribution.transaction_flag"
                                        min="0"/></td>
                                    <td>{{ distribution.qty_03 }}</td>
                                    <td><input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="distribution.result_qty_03"
                                        @change="updProdQty(distributionIdx)"
                                        :disabled="distribution.transaction_flag"
                                        min="0"/></td>
                                    <td>{{ distribution.qty_04 }}</td>
                                    <td><input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="distribution.result_qty_04"
                                        @change="updProdQty(distributionIdx)"
                                        :disabled="distribution.transaction_flag || distribution.qty_04 == null"
                                        min="0"/></td>
                                    <td>{{ distribution.loss_qty }}</td>
                                    <td><input type="number" 
                                        class="form-control" 
                                        v-model="distribution.result_loss_qty" 
                                        :disabled="distribution.transaction_flag"
                                        min="0"/></td>
                                    <td>{{ distribution.product_qty }}</td>
                                    <td>{{ distribution.unit_of_measure }}</td>
                                    <td>
                                        <input type="checkbox" v-model="distribution.transaction_flag" disabled>
                                    </td>
                                    <td>
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            @click.prevent="onClickUseProd(distributionIdx)"
                                            :disabled="distribution.transaction_flag">ตัดใช้วัตถุดิบ</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="11">ยอดรวมทุกเครื่อง</td>
                                    <td>{{ totalLossQty }}</td>
                                    <td>{{ totalProdQty }}</td>
                                    <td>{{ header.uom }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tbody v-else><tr><td colspan="16">ไม่มีข้อมูล</td></tr></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    showProgressWithUnsavedChangesWarningDialog,
    showSaveSuccessDialog,
    showSaveFailureDialog,
    showRemoveLineConfirmationDialog,
    showValidationFailedDialog
} from "../../commonDialogs"
export default {
    props: ['headers', 'lines', 'distributions', 'steps'],
    data() {
        return {
            header: {
                batch_no: '',
                product_type: '',
                item_code: '',
                item_desc: '',
                request_qty: '',
                uom: '',
                blend_no: '',
                start_date: '',
                product_qty: '',
            },
            lookupSteps: [],
            stepCode: '',
            stepDesc: '',
            selectedLines: [],
            displayProdDate: '',
            selectedDistributions: [],
            lineIdx: '',
        }
    },
    mounted() {
        console.log(this.distributions)
    },
    computed: {
        totalLossQty() {
            let total = 0
            this.selectedDistributions.forEach(distribution => {
                if(distribution.result_loss_qty > 0) {
                    total += parseInt(distribution.result_loss_qty)
                }
            })
            if(!this.lineIdx) {
                this.selectedLines[this.lineIdx].loss_qty = total
            }
            return total
        },
        totalProdQty() {
            let total = 0
            this.selectedDistributions.forEach(distribution => {
                if(distribution.product_qty > 0) {
                    total += parseInt(distribution.product_qty)
                }
            })
            if(!this.lineIdx) {
                this.selectedLines[this.lineIdx].product_qty = total
            }
            return total
        }
    },
    methods: {
        resetForm() {
            console.log('resetForm')
            this.header = {
                batch_no: '',
                product_type: '',
                item_code: '',
                item_desc: '',
                request_qty: '',
                uom: '',
                blend_no: '',
                start_date: '',
                product_qty: '',
            },
            this.lookupSteps = []
            this.stepCode = ''
            this.stepDesc = ''
            this.selectedLines = []
            this.displayProdDate = ''
            this.selectedDistributions = []
        },
        validate() {
            let errors = []
            if(!this.header.batch_no) {
                errors.push('ยังไม่ได้เลือก Header')
            } 
            if(this.selectedLines.length == 0) {
                errors.push('ยังไม่ได้เลือก Line')
            }
            if(this.selectedDistributions.length == 0) {
                errors.push('ยังไม่ได้เลือก Distribution')
            }
            if(errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        saveForm() {
            console.log('saveForm!!!')
            if(!this.validate()) {
                return;
            }
            let params = {
                header: this.header,
                lines: this.selectedLines,
                distributions: this.selectedDistributions,
            }
            axios.put('/api/pm/pm0030/' + this.header.batch_id, params).then(response => {
                if (response.status == 200) {
                    // this.setterData(response.data)
                    console.log(response)
                    showSaveSuccessDialog()
                }
            }).catch(error => {
                console.log(error)
            })
        },
        calTransferQty(idx) {
            let transferQty = 0
            if(this.selectedLines[idx].receive_wip > 0) {
                transferQty += parseInt(this.selectedLines[idx].receive_wip)
            }
            if(this.selectedLines[idx].product_qty > 0) {
                transferQty += parseInt(this.selectedLines[idx].product_qty)
            }
            if(this.selectedLines[idx].loss_qty > 0) {
                transferQty -= parseInt(this.selectedLines[idx].loss_qty)
            }
            if(this.selectedLines[idx].transfer_qty > 0) {
                transferQty -= parseInt(this.selectedLines[idx].transfer_qty)
            }
            this.selectedLines[idx].transfer_wip = transferQty

            if(this.selectedLines[idx + 1]) {
                this.selectedLines[idx + 1].receive_wip = transferQty
                this.calTransferQty(idx + 1)
            }
        },
        updProdQty(idx) {
            let prodQty = 0
            if(this.selectedDistributions[idx].result_qty_01 > 0) {
                prodQty += parseInt(this.selectedDistributions[idx].result_qty_01)
            }
            if(this.selectedDistributions[idx].result_qty_02 > 0) {
                prodQty += parseInt(this.selectedDistributions[idx].result_qty_02)
            }
            if(this.selectedDistributions[idx].result_qty_03 > 0) {
                prodQty += parseInt(this.selectedDistributions[idx].result_qty_03)
            }
            if(this.selectedDistributions[idx].result_qty_04 > 0) {
                prodQty += parseInt(this.selectedDistributions[idx].result_qty_04)
            }
            this.selectedDistributions[idx].product_qty = prodQty
        },
        onChangeLookupHeader() {
            this.lookupSteps = []
            let idx = this.headers.findIndex(header => header.batch_no == this.header.batch_no)
            this.header = this.headers[idx]
            let steps = this.lines.filter(line => line.batch_id == this.header.batch_id)
            let distinctSteps = [...new Set(steps.map(line => line.wip_step))]
            distinctSteps.map(step => this.lookupSteps.push({ code: step }))
            // console.log(this.selectedLines)
        },
        onChangeLookupStep() {
            let idx = this.steps.findIndex(step => step.lookup_code == this.stepCode)
            this.stepDesc = (idx >= 0)? this.steps[idx].meaning: '-'
            this.selectedLines = []
            this.selectedLines = this.lines.filter(line => {
                return line.batch_id == this.header.batch_id && line.wip_step == this.stepCode
            })
        },
        selectLine(batchId, productDate, wipStep, lineIdx) {
            this.displayProdDate = productDate
            this.lineIdx = lineIdx
            this.selectedDistributions = this.distributions.filter(distribution => {
                return distribution.batch_id == this.header.batch_id && distribution.product_date == productDate && distribution.wip_step == wipStep
            })
        },
        onClickUseProd(distributionIdx) {
            let params = {
                batch_id: this.selectedDistributions[distributionIdx].batch_id,
                wip_step: this.selectedDistributions[distributionIdx].wip_step,
                product_date: this.selectedDistributions[distributionIdx].product_date,
                machine_set: this.selectedDistributions[distributionIdx].machine_set,
            }
            axios.put('/api/pm/transaction-pkg-product', params).then(response => {
                if (response.status == 200) {
                    // this.setterData(response.data)
                    this.selectedDistributions[distributionIdx].transaction_flag = true
                    console.log(response)
                    showSaveSuccessDialog()
                }
            }).catch(error => {
                console.log(error)
            })
        },
    },
}
</script>