<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">รหัสวัตถุดิบ</label>
                                    <div class="col-lg-8">
                                        <el-select 
                                            v-model="seg" 
                                            clearable
                                            filterable 
                                            remote 
                                            placeholder="เลือกประเภทวัตฤติบ" 
                                            :loading="false">
                                            <el-option 
                                                v-for="segment in segments" 
                                                :key="segment" 
                                                :label="segment" 
                                                :value="segment" >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">ประเภทวัตฤติบ</label>
                                    <div class="col-lg-8">
                                        <el-select 
                                            v-model="desc" 
                                            clearable
                                            filterable 
                                            remote 
                                            placeholder="เลือกประเภทวัตฤติบ" 
                                            :loading="false">
                                            <el-option 
                                                v-for="description in descriptions" 
                                                :key="description" 
                                                :label="description" 
                                                :value="description" >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">กลุ่มวัตถุดิบ</label>
                                    <div class="col-lg-8">
                                        <el-select 
                                            v-model="grp" 
                                            clearable
                                            filterable 
                                            remote 
                                            placeholder="เลือกกลุ่มวัตถุดิบ" 
                                            :loading="false">
                                            <el-option 
                                                v-for="group in groups" 
                                                :key="group" 
                                                :label="group" 
                                                :value="group" >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">คลังจัดเก็บ</label>
                                    <div class="col-lg-8">
                                        <el-select 
                                            v-model="inv" 
                                            clearable
                                            filterable 
                                            remote 
                                            placeholder="เลือกคลังจัดเก็บ" 
                                            :loading="false">
                                            <el-option 
                                                v-for="inventory in inventories" 
                                                :key="inventory" 
                                                :label="inventory" 
                                                :value="inventory" >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">สถานที่จัดเก็บ</label>
                                    <div class="col-lg-8">
                                        <el-select 
                                            v-model="loc" 
                                            clearable
                                            filterable 
                                            remote 
                                            placeholder="เลือกสถานที่จัดเก็บ" 
                                            :loading="false">
                                            <el-option 
                                                v-for="locator in locators" 
                                                :key="locator" 
                                                :label="locator" 
                                                :value="locator" >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label">แสดง Lot</label>
                                    <div class="col-lg-6">
                                        <label class="container">
                                            <input type="checkbox" v-model="displayLotNo"/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label class="col-lg-6 col-sm-4 col-form-label">ปริมาณคงคลังต่ำกว่าที่กำหนด</label>
                                    <div class="col-lg-6">
                                        <label class="container">
                                            <input type="checkbox" v-model="underInv"/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-6 col-sm-4 col-form-label">วัตถุดิบใกล้หมดอายุ</label>
                                    <div class="col-lg-6">
                                        <label class="container">
                                            <input type="checkbox" v-model="closeToExp"/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-6 col-sm-4 col-form-label">Hold</label>
                                    <div class="col-lg-6">
                                        <label class="container">
                                            <input type="checkbox" v-model="hold"/>
                                            <span class="checkmark"></span>
                                        </label>
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
                                class="btn btn-w-m btn-default"
                                @click.prevent="onClickSearchBtn">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>รหัสวัตถุดิบ</th>
                                            <th style="min-width: 250px;">รายละเอียด</th>
                                            <th>ประเภทวัตถุดิบ</th>
                                            <th>กลุ่มวัตถุดิบ</th>
                                            <th>คลังจัดเก็บ</th>
                                            <th>สถานที่จัดเก็บ</th>
                                            <th>Lot No.</th>
                                            <th>ปริมาณคงคลัง</th>
                                            <th>หน่วย</th>
                                            <th>ปริมาณจัดเก็บต่ำสุด</th>
                                            <th>ปริมาณจัดเก็บมากสุด</th>
                                            <th>วันที่ได้รับ</th>
                                            <th>วันหมดอายุ</th>
                                            <th>hold</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="rows.length">
                                        <tr v-for="row in rows">
                                            <td>{{ row.segment1 }}</td>
                                            <td>{{ row.lookup_code }}</td>
                                            <td>{{ row.description }}</td>
                                            <td>{{ row.tobacco_group }}</td>
                                            <td>{{ row.subinventory_code }}</td>
                                            <td>{{ row.locator_code }}</td>
                                            <td>{{ row.lot_number }}</td>
                                            <td>{{ row.onhand_quantity }}</td>
                                            <td>{{ row.primary_uom_code }}</td>
                                            <td>{{ row.min_qty }}</td>
                                            <td>{{ row.max_qty }}</td>
                                            <td>{{ row.origination_date }}</td>
                                            <td>{{ row.expiration_date }}</td>
                                            <td>
                                                <div class="form-check abc-checkbox form-check-inline m-l-md">
                                                    <input class="form-check-input" type="checkbox" :checked="row.hold_date=='Y'" disabled/>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="14">ไม่พบข้อมูล</td>
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
    showSaveSuccessDialog,
    showSaveFailureDialog,
} from "../../commonDialogs"

export default {
    props: ['data'],
    data() {
        return {
            rows: this.data,
            seg: '',
            desc: '',
            grp: '',
            inv: '',
            loc: '',
            displayLotNo: false,
            underInv: false,
            closeToExp: false,
            hold: false,
        }
    },
    mounted() {
        console.log('mounted !!!')
    },
    computed: {
        segments() {
            let segments = [...new Set(this.data.map(row => row.segment1))]
            return segments.sort()
        },
        descriptions() {
            let descriptions = [...new Set(this.data.map(row => row.description))]
            return descriptions.sort()
        },
        groups() {
            let groups = [...new Set(this.data.map(row => row.tobacco_group))]
            return groups.sort()
        },
        inventories() {
            let inventories = [...new Set(this.data.map(row => row.subinventory_code))]
            return inventories.sort()
        },
        locators() {
            let locators = [...new Set(this.data.map(row => row.locator_code))]
            return locators.sort()
        },
    },
    methods: {
        onClickResetBtn() {
            this.seg = ''
            this.desc = ''
            this.grp = ''
            this.inv = ''
            this.loc = ''
            this.displayLotNo = false
            this.underInv = false
            this.closeToExp = false
            this.hold = false
            // this.rows = this.data
        },
        onClickSearchBtn() {
            console.log('onClickSearchBtn')
            showLoadingDialog()
            let params = {
                segment1: this.seg,
                description: this.desc,
                tobacco_group: this.grp,
                subinventory_code: this.inv,
                locator_code: this.loc,
                display_lot_no: this.displayLotNo,
                under_inv: this.underInv,
                close_to_exp: this.closeToExp,
                hold: this.hold,
            }
            axios.post('/api/pm/pm0029/', params).then(response => {
                if (response.status == 200) {
                    this.rows = response.data
                    swal.close() 
                    console.log('status 200')
                    console.log(response)
                }
            }).catch(error => {
                console.log(error)
            })
        },
    },
}
</script>

<style scoped>
    th,
    td {
        vertical-align: middle !important;
        text-align: center;

    }

    .form-check-input {
        width: 20px;
        height: 45px;
        border: 1px solid #e5e6e7;
    }

    .checkbox label::before {
        content: "";
        display: inline-block;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
    }
    .container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 10px;
  left: 0;
  height: 20px;
  width: 20px;
  border: 1px solid #e5e6e7;
  border-radius: 4px;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
   border: 1px solid #e5e6e7;
  border-radius: 4px;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #1ab394;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

</style>
