<template>
    <div class="row">
        <!--        <pre>{{ JSON.stringify({-->
        <!--            selectedLines,-->
        <!--            selectedDistributions,-->
        <!--        }, null, 2) }}</pre>-->
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>ยืนยันยอดผลผลิตสูญ,สูญเสีย (มวน)</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">เลขที่คำสั่งผลิต <span
                                    style="color: red;">*</span>:</label>
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
                                            :value="lookupHeader.batch_no">
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
                                            <input type="text" class="form-control" v-model="header.request_qty"
                                                   disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" v-model="header.uom" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">ขั้นตอนการทำงาน<span
                                    style="color: red;">*</span>:</label>
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
                                                    :value="step.code">
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
                                            <input type="text" class="form-control" v-model="header.product_qty"
                                                   disabled>
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
                <button type="button" @click.prevent="resetForm" class="btn btn-default"><i class="fa fa-refresh"></i>
                    ล้างค่า
                </button>
                <button type="button" @click.prevent="saveForm" class="btn btn-primary"><i class="fa fa-save"></i>
                    บันทึก
                </button>
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
                            <tr v-for="(line, lineIdx) in selectedLines" :key="lineIdx"
                                :class="{ disable :line.transaction_flag}">
                                <td class="g">
                                    <a class="text-info"
                                       @click.prevent="selectLine(line.batch_id, line.product_date, line.wip_step, lineIdx)">{{
                                            line.product_date
                                        }}</a>
                                </td>
                                <td class="g">{{ line.receive_wip }}</td>
                                <td class="g">{{ line.product_qty }}</td>
                                <td class="g">{{ line.loss_qty }}</td>
                                <td>
                                    <input type="number"
                                           class="form-control form-control-sm"
                                           v-model="line.transfer_qty"
                                           :disabled="line.transaction_flag"
                                           min="0"/>
                                </td>
                                <td class="g">{{ totalTranWip(lineIdx) }}</td>
                                <td class="g">{{ line.uom }}</td>
                                <td class="g">
                                    <input type="checkbox" v-model="line.transaction_flag" disabled/>
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
                                <th rowspan="2">ยอดผลผลิตรวมทั้งวัน</th>
                                <th rowspan="2">ยอดสูญเสียรวมทั้งวัน</th>
                                <th rowspan="2">ยืนยันยอดสูญเสียรวมทั้งวัน</th>
                                <th rowspan="2">จำนวนบุหรี่ตัวอย่าง</th>
                                <th rowspan="2">รวมยอดบุหรี่</th>
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
                            <tr v-for="(distribution, distributionIdx) in selectedDistributions" :key="distributionIdx"
                                :class="{ disable :distribution.transaction_flag}">
                                <td class="g">{{ distribution.machine_set }}</td>
                                <td class="g">{{ distribution.machine_number }}</td>
                                <td class="g">{{ distribution.qty_01 }}</td>
                                <td><input
                                    type="number"
                                    class="form-control form-control-sm"
                                    v-model="distribution.result_qty_01"
                                    :disabled="distribution.transaction_flag"
                                    min="0"/></td>
                                <td class="g">{{ distribution.qty_02 }}</td>
                                <td><input
                                    type="number"
                                    class="form-control form-control-sm"
                                    v-model="distribution.result_qty_02"
                                    :disabled="distribution.transaction_flag"
                                    min="0"/></td>
                                <td class="g">{{ distribution.qty_03 }}</td>
                                <td><input
                                    type="number"
                                    class="form-control form-control-sm"
                                    v-model="distribution.result_qty_03"
                                    :disabled="distribution.transaction_flag"
                                    min="0"/></td>
                                <td class="g">{{ distribution.qty_04 }}</td>
                                <td :class="{g: distribution.qty_04 == null}"><input
                                    type="number"
                                    class="form-control form-control-sm"
                                    v-model="distribution.result_qty_04"
                                    :disabled="distribution.transaction_flag || distribution.qty_04 == null"
                                    min="0"/></td>
                                <td class="g">{{ total1(distributionIdx) }}</td><!-- COL.11 => TOTAL#1 -->
                                <td class="g">{{ distribution.loss_qty }}</td>
                                <td><input type="number"
                                           class="form-control form-control-sm"
                                           v-model="distribution.result_loss_qty"
                                           :disabled="distribution.transaction_flag"
                                           min="0"/></td>
                                <td><input type="number"
                                           class="form-control form-control-sm"
                                           v-model="distribution.sample_qty"
                                           :disabled="distribution.transaction_flag"
                                           min="0"/></td>
                                <td class="g">{{ total2(distributionIdx) }}</td>
                                <td class="g">{{ distribution.unit_of_measure }}</td>
                                <td class="g">
                                    <input type="checkbox" v-model="distribution.transaction_flag" disabled>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-default"
                                        @click.prevent="onClickUseProd(distributionIdx)"
                                        :disabled="distribution.transaction_flag">ตัดใช้วัตถุดิบ
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="g text-right" colspan="10">ยอดรวมทุกเครื่อง</td>
                                <td class="g">{{ sumTotal1 }}</td><!-- SUM TOTAL#1 -->
                                <td class="g">{{ sumTotalLoss }}</td>
                                <td class="g">{{ sumTotalResultLoss }}</td>
                                <td class="g">{{ sumTotalSample }}</td>
                                <td class="g">{{ sumTotalProd }}</td>
                                <td class="g">{{ selectedLines[lineIdx].uom }}</td>
                                <td class="g"></td>
                                <td class="g"></td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td colspan="18">ไม่มีข้อมูล</td>
                            </tr>
                            </tbody>
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
    // mounted() {
    //     console.log(this.distributions)
    // },
    computed: {
        sumTotal1() {
            let total = 0
            this.selectedDistributions.forEach((dist, i) => {
                total += this.total1(i)
            })
            return total
        },
        sumTotalLoss() {
            let total = 0
            this.selectedDistributions.forEach(distribution => {
                if (distribution.loss_qty > 0) {
                    total += parseInt(distribution.loss_qty)
                }
            })
            return total
        },
        sumTotalResultLoss() {
            let total = 0
            this.selectedDistributions.forEach(distribution => {
                if (distribution.result_loss_qty > 0) {
                    total += parseInt(distribution.result_loss_qty)
                }
            })
            if (this.lineIdx != null) {
                this.selectedLines[this.lineIdx].loss_qty = total
            }
            return total
        },
        sumTotalSample() {
            let total = 0
            this.selectedDistributions.forEach(distribution => {
                total += 0
                if (distribution.sample_qty > 0) {
                    total += parseInt(distribution.sample_qty)
                }
            })
            return total
        },
        sumTotalProd() {
            let total = 0
            this.selectedDistributions.forEach((dist, i) => {
                total += this.total2(i)
            })
            if (this.lineIdx != null) {
                this.selectedLines[this.lineIdx].product_qty = total
            }
            return total
        }
    },
    methods: {
        resetForm() {
            // console.log('resetForm')
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
            if (!this.header.batch_no) {
                errors.push('ยังไม่ได้เลือก Header')
            }
            if (this.selectedLines.length == 0) {
                errors.push('ยังไม่ได้เลือก Line')
            }
            if (this.selectedDistributions.length == 0) {
                errors.push('ยังไม่ได้เลือก Distribution')
            }
            if (errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        saveForm(showSaveSuccessDialogWhenDone = true) {
            console.log('saveForm!!!')
            if (!this.validate()) {
                return;
            }
            let params = {
                header: this.header,
                lines: this.selectedLines,
                distributions: this.selectedDistributions,
            }
            return axios.put('/api/pm/pm0025/' + this.header.batch_id, params).then(response => {
                if (response.status == 200) {
                    // this.setterData(response.data)
                    console.log(response)
                    if (showSaveSuccessDialogWhenDone) showSaveSuccessDialog()
                }
            }).catch(error => {
                swal.close()
                console.log(error)
            })
        },
        // calTransferQty(idx) {
        //     let transferQty = 0
        //     if(this.selectedLines[idx].receive_wip > 0) {
        //         transferQty += parseInt(this.selectedLines[idx].receive_wip)
        //     }
        //     if(this.selectedLines[idx].product_qty > 0) {
        //         transferQty += parseInt(this.selectedLines[idx].product_qty)
        //     }
        //     if(this.selectedLines[idx].loss_qty > 0) {
        //         transferQty -= parseInt(this.selectedLines[idx].loss_qty)
        //     }
        //     if(this.selectedLines[idx].transfer_qty > 0) {
        //         transferQty -= parseInt(this.selectedLines[idx].transfer_qty)
        //     }
        //     this.selectedLines[idx].transfer_wip = transferQty

        //     if(this.selectedLines[idx + 1]) {
        //         this.selectedLines[idx + 1].receive_wip = transferQty
        //         this.calTransferQty(idx + 1)
        //     }
        // },
        // updProdQty(idx) {
        //     let prodQty = 0
        //     if(this.selectedDistributions[idx].result_qty_01 > 0) {
        //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_01)
        //     }
        //     if(this.selectedDistributions[idx].result_qty_02 > 0) {
        //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_02)
        //     }
        //     if(this.selectedDistributions[idx].result_qty_03 > 0) {
        //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_03)
        //     }
        //     if(this.selectedDistributions[idx].result_qty_04 > 0) {
        //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_04)
        //     }
        //     // add for pm0025
        //     if(this.selectedDistributions[idx].sample_qty > 0) {
        //         prodQty += parseInt(this.selectedDistributions[idx].sample_qty)
        //     }
        //     this.selectedDistributions[idx].product_qty = prodQty
        // },
        onChangeLookupHeader() {
            this.lookupSteps = []
            let idx = this.headers.findIndex(header => header.batch_no == this.header.batch_no)
            this.header = this.headers[idx]
            let steps = this.lines.filter(line => line.batch_id == this.header.batch_id)
            let distinctSteps = [...new Set(steps.map(line => line.wip_step))]
            distinctSteps.map(step => this.lookupSteps.push({code: step}))
            // console.log(this.selectedLines)
        },
        onChangeLookupStep() {
            let idx = this.steps.findIndex(step => step.lookup_code == this.stepCode)
            this.stepDesc = (idx >= 0) ? this.steps[idx].meaning : '-'
            this.selectedLines = []
            this.selectedLines = this.lines.filter(line => {
                return line.batch_id == this.header.batch_id && line.wip_step == this.stepCode
            })
            this.selectedDistributions = []
        },
        selectLine(batchId, productDate, wipStep, lineIdx) {
            // console.log('batchId => ' + batchId + ' productDate => ' + productDate + ' wipStep => ' + wipStep + ' lineIdx => ' + lineIdx)
            this.displayProdDate = productDate
            this.lineIdx = lineIdx
            this.selectedDistributions = this.distributions.filter(distribution => {
                return distribution.batch_id == this.header.batch_id && distribution.product_date == productDate && distribution.wip_step == wipStep
            })
        },
        async onClickUseProd(distributionIdx) {
            // save form before call pkg
            await this.saveForm(false)

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
                    this.setLineTxFlg()
                    console.log(response)
                    showSaveSuccessDialog()
                }
            }).catch(error => {
                console.log(error)
            })
        },
        setLineTxFlg() {
            let lineTxFlg = true
            this.selectedDistributions.forEach(distribution => {
                if (!distribution.transaction_flag) {
                    lineTxFlg = false
                }
            })
            this.selectedLines[this.lineIdx].transaction_flag = lineTxFlg
        },
        total1(distIdx) {
            let total = 0
            if (this.selectedDistributions[distIdx].result_qty_01 > 0) {
                total += parseInt(this.selectedDistributions[distIdx].result_qty_01)
            }
            if (this.selectedDistributions[distIdx].result_qty_02 > 0) {
                total += parseInt(this.selectedDistributions[distIdx].result_qty_02)
            }
            if (this.selectedDistributions[distIdx].result_qty_03 > 0) {
                total += parseInt(this.selectedDistributions[distIdx].result_qty_03)
            }
            if (this.selectedDistributions[distIdx].result_qty_04 > 0) {
                total += parseInt(this.selectedDistributions[distIdx].result_qty_04)
            }
            // add for pm0025
            // if(this.selectedDistributions[idx].sample_qty > 0) {
            //     prodQty += parseInt(this.selectedDistributions[idx].sample_qty)
            // }
            return total
            // this.selectedDistributions[idx].product_qty = prodQty
        },
        total2(distIdx) {
            let total1 = this.total1(distIdx)
            let sampleQty = this.selectedDistributions[distIdx].sample_qty > 0 ? this.selectedDistributions[distIdx].sample_qty : 0
            let total2 = parseInt(total1) + parseInt(sampleQty)
            return total2
        },
        totalTranWip(idx) {
            let total = 0
            if (this.selectedLines[idx].receive_wip > 0) {
                total += parseInt(this.selectedLines[idx].receive_wip)
            }
            if (this.selectedLines[idx].product_qty > 0) {
                total += parseInt(this.selectedLines[idx].product_qty)
            }
            if (this.selectedLines[idx].loss_qty > 0) {
                total -= parseInt(this.selectedLines[idx].loss_qty)
            }
            if (this.selectedLines[idx].transfer_qty > 0) {
                total -= parseInt(this.selectedLines[idx].transfer_qty)
            }
            this.selectedLines[idx].transfer_wip = total

            if (this.selectedLines[idx + 1]) {
                this.selectedLines[idx + 1].receive_wip = total
                this.totalTranWip(idx + 1)
            }

            return total
        },
    },
}
</script>
<style>
.table tbody tr.disable {
    background-color: #F2F2F2;
}

.table td.g {
    background-color: #F2F2F2;
}
</style>
