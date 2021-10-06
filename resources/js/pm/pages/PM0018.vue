<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-lg-4 align-middle">
                            <h5>คำสั่งผลิตยาเส้นปรุงประจำปักษ์</h5>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">แผนการผลิตประจำปีงบประมาณ:</label>
                                <div class="col-lg-9">
                                    <el-select v-model="thai_year" filterable remote placeholder="เลือกปีงบประมาณ" @change="onChangeYear()">
                                        <el-option v-for="year in yearList" :key="year" :label="year" :value="year"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">ประจำเดือน:</label>
                                <div class="col-lg-9">
                                    <el-select v-model="thai_month" filterable remote placeholder="เลือกเดือน" @change="onChangeMonth()">
                                        <el-option v-for="month in monthList" :key="month" :label="month" :value="month"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">ปักษ์ที่:</label>
                                <div class="col-lg-9">
                                    <el-select v-model="biweekly" filterable remote placeholder="เลือกปักษ์" @change="onChangeBiWeekly()">
                                        <el-option v-for="biweekly in biweeklyList" :key="biweekly" :label="biweekly" :value="biweekly"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">วันที่:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" v-model="display_date" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="min-width: 150px;">Job Number</th>
                                    <th style="min-width: 150px;">Blend No.</th>
                                    <th>ปริมาณที่ต้องผลิต</th>
                                    <th>หน่วยนับ</th>
                                    <th style="min-width:150px;"></th>
                                    <th>ประเภทคำสั่งการผลิต</th>
                                </tr>
                            </thead>
                            <tbody v-if="rows.length">
                                <tr v-for="(row, index) in rows">
                                    <td>{{ row.batch_no }}</td>
                                    <td>{{ row.blend_no }}</td>
                                    <td>{{ row.plan_qty }}</td>
                                    <td>{{ row.dtl_um }}</td>
                                    <td>
                                        <div class="text-center">
                                            <button type="button" data-toggle="modal" class="btn btn-w-m btn-default" data-target="#modal-form" :disabled="!row.item_desc" @click.prevent="onClickDtl(index)"><i class="fa fa-file-text-o"></i> รายละเอียด</button>
                                        </div>
                                    </td>
                                    <td>{{ row.description }}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6">ไม่พบข้อมูล</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog" style="top:30%">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3 class="m-t-none m-b">แสดงรายละเอียดในแต่ละ Blend</h3>
                                            <form role="form">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ตราบุหรี่</th>
                                                            <th>จำนวน</th>
                                                            <th>หน่วย</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ desc }}</td>
                                                            <td>{{ qty }}</td>
                                                            <td>{{ unit }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    props: ['lookups', 'department_code', ],
    mounted() {
        // To do
    },
    data() {
        return {
            thai_year: new Date().getFullYear() + 543,
            thai_month: '',
            // period_num: '',
            biweekly: '',
            display_date: '',
            start_date: '',
            end_date: '',
            rows: '',
            desc: '',
            qty: '',
            unit: '',
        }
    },
    computed: {
        yearList() {
            return [...new Set(Array.from(this.lookups, (lookup) => lookup.thai_year))]
        },
        monthList() {
            let lookups = this.lookups.filter(lookup => lookup.thai_year == this.thai_year)
            return [...new Set(Array.from(lookups, (lookup) => lookup.thai_month))]
        },
        biweeklyList() {
            let lookups = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month.includes(this.thai_month)
            })
            return [...new Set(Array.from(lookups, (lookup) => lookup.biweekly))]
        },
    },
    methods: {
        onChangeYear() {
            this.thai_month = ''
            this.biweekly = ''
            this.display_date = ''
        },
        onChangeMonth() {
            this.biweekly = ''
            this.display_date = ''
        },
        onChangeBiWeekly() {
            let lookup = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month.includes(this.thai_month) && lookup.biweekly == this.biweekly
            })[0]
            this.start_date = lookup.start_date.split(' ')[0]
            this.end_date = lookup.end_date.split(' ')[0]
            this.display_date = lookup.start_date.split(' ')[0].split('-')[2] + '-' + lookup.end_date.split(' ')[0].split('-')[2] + ' ' + lookup.thai_month.trim() + ' ' + lookup.thai_year

            showLoadingDialog()

            axios.get('/api/pm/0018/', {
                params: {
                    start_date: this.start_date,
                    end_date: this.end_date,
                    department_code: this.department_code,
                }
            }).then(response => {
                if (response.status == 200) {
                    swal.close()
                    this.rows = response.data.rows
                }
                console.log(response)
            }).catch(error => {
                swal.close()
                console.log(error)
            })
        },
        onClickDtl(index) {
            let row = this.rows[index]
            this.desc = row.item_desc
            this.qty = row.quantity
            this.unit = row.primary_unit_of_measure
        }
    }
}
</script>
<style scoped>
    th,
    td {
        vertical-align: middle !important;
        text-align: center;

    }

</style>
