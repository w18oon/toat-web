<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right mb-3">
                <button class="btn btn-success" @click="onClickCreate"><i class="fa fa-plus"></i> สร้าง</button>
                <button class="btn btn-primary" :disabled="checkDisableBtn">
                    <!-- <i class="fa fa-save"></i>  -->
                แผนประจำปักษ์</button>
                <button class="btn btn-primary" @click.prevent="onClickSave" :disabled="checkDisableBtn"><i class="fa fa-save"></i> ประมาณการเบิก</button>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ขอเบิกวัตถุดิบตามแผนรายปักษ์</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 b-r">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">แผนการผลิตประจำปี: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="thai_year" filterable remote placeholder="เลือกปี" @change="onChangeYear">
                                        <el-option v-for="year in yearLists" :key="year" :label="year" :value="year"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">แผนการผลิตประจำเดือน: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="thai_month" filterable remote placeholder="เลือกเดือน" @change="onChangeMonth">
                                        <el-option v-for="month in monthLists" :key="month" :label="month" :value="month"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ปักษ์ที่: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="biweekly" filterable remote placeholder="เลือกปักษ์" @change="onChangeBiweekly">
                                        <el-option v-for="biweekly in biweeklyLists" :key="biweekly" :label="biweekly" :value="biweekly"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">วันที่ขอเบิก: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่ขอเบิก" :not-before-date="current_date" :not-after-date="maxSelectedDate" :value="req_date" format="YYYY-MM-DD" @dateWasSelected="(dateObject) => req_date = dateObject"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ประเภทวัตถุดิบ: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="item_code" filterable remote placeholder="เลือกประเภทวัตถุดิบ">
                                        <el-option v-for="item in items" :key="item.item_classification_code" :label="item.item_classification" :value="item.item_classification_code"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">วันที่ผลิต<span style="color:red">*</span></label>
                                <label class="col-lg-1 col-form-label">ตั้งแต่</label>
                                <div class="col-lg-4">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่" :not-before-date="min_date" :not-after-date="max_date" :value="start_date" format="YYYY-MM-DD" @dateWasSelected="(dateObject) => start_date = dateObject"/>
                                </div>
                                <label class="col-lg-1 col-form-label">ถึง</label>
                                <div class="col-lg-4">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่" :not-before-date="min_date" :not-after-date="max_date" :value="end_date" format="YYYY-MM-DD" @dateWasSelected="(dateObject) => end_date = dateObject"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">หน่วยงานที่ขอเบิก:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="dep_code" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ผู้ขอเบิก:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="req_by" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">วันที่นำส่ง ยสท.<span style="color:red">*</span>:</label>
                                <div class="col-lg-8">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่นำส่ง ยสท." :not-before-date="req_date" :not-after-date="maxSelectedDate"  :value="send_date" format="YYYY-MM-DD" @dateWasSelected="(dateObject) => send_date = dateObject"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right mb-3">
                <button type="button" class="btn btn-w-m btn-success" @click.prevent="onClickSaveLines" :disabled="checked.length == 0"><i class="fa fa-plus"></i> สร้างรายการขอเบิก</button>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>รายการวัตถุดิบ</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input class="align-middle" type="checkbox" @click="checkedAll" v-model="isCheckedAll">
                                        </label>
                                    </th>
                                    <th>กลุ่มใบยา</th>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th>รายละเอียด</th>
                                    <th>ปริมาณที่ต้องใช้+สูญเสีย</th>
                                    <th>หน่วยนับ</th>
                                    <th>ปริมาณคงคลังฝ่ายจัดหา</th>
                                    <th>ปริมาณที่คงคลังฝ่ายผลิต</th>
                                    <th>หน่วยนับ2</th>
                                    <th>ปริมาณจัดเก็บต่ำสุด</th>
                                    <th>ปริมาณจัดเก็บสูงสุด</th>
                                    <th>ปริมาณเต็มแป้น</th>
                                    <th>ปริมาณเบิก</th>
                                    <th>หน่วยเบิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(line, index) in lines" :key="index">
                                    <td>
                                        <label>
                                            <input class="align-middle" type="checkbox" v-model="checked" :disabled="!line.request_qty" :value="line.bi_request_line_id" @change="updateChecked">
                                        </label>
                                    </td>
                                    <td class="col-readonly">{{ line.item_type }}</td>
                                    <td class="col-readonly">{{ line.item_code }}</td>
                                    <td class="col-readonly">{{ line.description }}</td>
                                    <td class="col-readonly">{{ line.total_qty }}</td>
                                    <td class="col-readonly">{{ line.uom }}</td>
                                    <td class="col-readonly">{{ line.request_onhand }}</td>
                                    <td class="col-readonly">{{ line.product_onhand }}</td>
                                    <td class="col-readonly">{{ line.uom2 }}</td>
                                    <td class="col-readonly">{{ line.min_qty }}</td>
                                    <td class="col-readonly">{{ line.max_qty }}</td>
                                    <td class="col-readonly">{{ line.machine_max }}</td>
                                    <td>
                                        <input type="number" class="form-control input-field" v-model="line.request_qty" min="0">
                                    </td>
                                    <td class="col-readonly">{{ line.request_uom }}</td>
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
// import showLoadingDialog from "../../commonDialogs"
import {
    showLoadingDialog,
    showValidationFailedDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
    showRemoveLineConfirmationDialog,
} from "../../commonDialogs"

export default {
    props: ['lookups', 'items', 'dep_code', 'req_by'],
    mounted() {
        // To do
    },
    data() {
        return {
            current_date: this.getCurrentDate(),
            header_id: '',
            thai_year: new Date().getFullYear() + 543,
            thai_month: '',
            biweekly: '',
            biweekly_id: '',
            req_date: this.getCurrentDate(),
            item_code: '',
            start_date: '',
            end_date: '',
            min_date: '',
            max_date: '',
            send_date: this.getCurrentDate(),
            lines: [],
            isCheckedAll: false,
            checked: [],
        }
    },
    computed: {
        maxSelectedDate() {
            let today = new Date()
            let max = new Date()
            max.setDate(today.getDate() + 365)
            let thaiYear = max.getFullYear() + 543
            let month = max.getMonth() + 1
            let day = max.getDate()
            return thaiYear + '-' + month + '-' + day
        },
        checkDisableBtn() {
            return ! (this.thai_year && this.thai_month && this.biweekly && this.item_code)
        },
        yearLists() {
            return [...new Set(Array.from(this.lookups, (lookup) => lookup.thai_year))]
        },
        monthLists() {
            let lookups = this.lookups.filter(lookup => lookup.thai_year == this.thai_year)
            return [...new Set(Array.from(lookups, (lookup) => lookup.thai_month))]
        },
        biweeklyLists() {
            let lookups = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month == this.thai_month
            })
            return [...new Set(Array.from(lookups, (lookup) => lookup.biweekly))]
        },
    },
    methods: {
        onClickCreate() {
            // To do
            this.thai_year = new Date().getFullYear() + 543,
            this.thai_month = ''
            this.biweekly = ''
            this.biweekly_id = ''
            this.req_date = this.getCurrentDate()
            this.item_code = ''
            this.start_date = ''
            this.end_date = ''
            this.send_date = this.getCurrentDate(),
            this.lines = ''
        },
        onClickSave() {
            let params = {
                biweekly_id: this.biweekly_id,
                department_code: this.dep_code,
                request_date: this.convertFormatDate(this.req_date),
                tobacco_group: this.item_code,
                product_date_from: this.convertFormatDate(this.start_date),
                product_date_to: this.convertFormatDate(this.end_date),
                request_by: this.req_by,
                send_date: this.convertFormatDate(this.send_date),
            }
            showLoadingDialog()
            axios.post('/api/pm/0019/', params).then(response => {
                if (response.status == 200) {
                    console.log(response)
                    showSaveSuccessDialog()
                    this.lines = response.data.lines
                    this.header_id = response.data.header.bi_request_header_id
                }
            }).catch(error => {
                console.log(error)
            })
        },
        getCurrentDate() {
            let y = new Date().getFullYear() + 543
            let m = new Date().getMonth() + 1
            let d = new Date().getDate()
            return y + '-' + m + '-' + d
        },
        convertToThaiDate(d) {
            let yearThai = parseInt(d.split('-')[0]) + 543
            return yearThai + '-' + d.split('-')[1] + '-' + d.split('-')[2]
        },
        convertFormatDate(d) {
            let yyyy = new Date(d).getFullYear() - 543
            let mm = new Date(d).getMonth() + 1
            let dd = new Date(d).getDate()
            return yyyy + '-' + mm + '-' + dd
        },
        onChangeYear() {
            // To do
            // this.thai_month = ''
            // this.biweekly = ''
            // this.display_date = ''
        },
        onChangeMonth() {
            // To do
            // this.biweekly = ''
            // this.display_date = ''
        },
        onChangeBiweekly() {
            // To do
            let lookup = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month ==this.thai_month && lookup.biweekly == this.biweekly
            })[0]
            this.biweekly_id = lookup.biweekly_id
            this.start_date = this.convertToThaiDate(lookup.start_date)
            this.min_date = this.convertToThaiDate(lookup.start_date)
            this.end_date = this.convertToThaiDate(lookup.end_date)
            this.max_date = this.convertToThaiDate(lookup.end_date)
        },
        validate() {
            let errors = []

            if(this.checked.length > 0) {
                this.checked.forEach(lineId => {
                    let line = this.lines.filter(line => { return line.bi_request_line_id == lineId })[0]
                    if (!line.request_qty) {
                        errors.push('ปริมาณเบิก')
                    }
                })
            }

            if(errors.length > 0) {
                showValidationFailedDialog([...new Set(errors)])
                return false
            }
            return true
        },
        onClickSaveLines() {
            if(!this.validate()) {
                return;
            }

            let params = {
                lines: this.lines,
                checked: this.checked
            }
            showLoadingDialog()
            axios.put('/api/pm/0019/' + this.header_id, params).then(response => {
                if (response.status == 200) {
                    swal.close()
                    if(response.data.req_header_id.length > 0){
                        window.location.href = '/pm/0005/' + response.data.req_header_id[0]
                    } else {
                        showValidationFailedDialog(response.data.errors);
                    }
                }
            }).catch(error => {
                swal.close()
                console.log(error)
            })
        },
        checkedAll() {
            this.checked = []
            this.isCheckedAll = !this.isCheckedAll
            if (this.isCheckedAll) {
                this.lines.forEach(line => {
                    if(line.request_qty) {
                        this.checked.push(line.bi_request_line_id)
                    }
                })
            }
        },
        updateChecked() {
            this.isCheckedAll = (this.checked.length === this.lines.length)
        },
    }
}
</script>
<style scoped>
    th, td {
        vertical-align: middle !important;
        text-align: center;
    }
    input.form-control.input-field { border: 0px; }
    .mx-datepicker { width: inherit !important; }
    .col-readonly { background: #e9ecef42 !important; }
</style>
