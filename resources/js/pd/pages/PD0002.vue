<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right mb-3">
                <button class="btn btn-success" @click="onClickCreate"><i class="fa fa-plus"></i> สร้าง</button>
                <button class="btn btn-default" data-toggle="modal" data-target="#searchForm"><i class="fa fa-search"></i> ค้นหา</button>
                <button class="btn btn-primary" @click="onClickSave"><i class="fa fa-save"></i> บันทึก</button>
                <button class="btn btn-default" data-toggle="modal" data-target="#copyModal"><i class="fa fa-copy"></i> คัดลอกสูตร</button>
                <button class="btn btn-default" data-toggle="modal" data-target="#historyModal"><i class="fa fa-file-text-o"></i> ประวัติแก้ไข</button>
            </div>
            <div class="ibox">
                <div class="ibox-title">สารหอม Flavor</div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">สารหอม Flavor No. <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="header.simu_formula_no" :disabled="header.last_update_date !== ''">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">รายละเอียด</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="header.description">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">หมายเหตุ</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="header.remark_formula">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่สร้าง</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="header.creation_date" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่แก้ไขล่าสุด</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="header.last_update_date" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">ผู้บันทึก</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="header.created_by" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right mb-3">
                <button class="btn btn-success" @click.prevent="addItem('lines')">เพิ่มรายการ</button>
                <button class="btn btn-danger" @click.prevent="deleteItem('lines')">ลบรายการ</button>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('lines')" v-model="isCheckedAll.lines">
                            </th>
                            <th>รหัสวัตถุดิบ</th>
                            <th>รายละเอียดวัตถุดิบ</th>
                            <th>สถานะ</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>หน่วยในคงคลัง</th>
                            <th>ปริมาณที่ใช้</th>
                            <th>หน่วย</th>
                            <th>ต้นทุนวัตถุดิบที่ใช้</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(line, index) in lines" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.lines" :value="index" @change="updateChecked('lines')">
                            </td>
                            <td>
                                <el-select 
                                    v-model="line.raw_material_num"
                                    filterable 
                                    remote 
                                    placeholder="ระบุรหัสวัตถุดิบ" 
                                    :loading="loading" 
                                    @change="onChangeRawMaterialNum(index)">
                                    <el-option 
                                        v-for="raw_mate in raw_mates" 
                                        :key="raw_mate.item_code" 
                                        :label="raw_mate.item_code" 
                                        :value="raw_mate.item_code" ></el-option>
                                </el-select>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.description" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.status" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.price_per_unit" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.uom" disabled>
                            </td>
                            <td>
                                <input type="number" class="form-control" v-model="line.actual_qty" @change="updateActualCost(index)" min=0>
                            </td>
                            <td>
                                <el-select 
                                    v-model="line.actual_uom"
                                    filterable 
                                    remote 
                                    placeholder="ระบุหน่วย" 
                                    :loading="loading" >
                                    <el-option 
                                        v-for="uom in uoms" 
                                        :key="uom.uom_code" 
                                        :label="uom.uom_code" 
                                        :value="uom.uom_code"></el-option>
                                </el-select>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.actual_cost" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <p class="text-right">รวมต้นทุนทั้งหมด</p>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="updateTotalCost" disabled>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row m-b">
                <div class="col-lg-6">
                    <h3>วิธีผสม</h3>
                </div>
                <div class="col-lg-6">
                    <div class="text-right">
                        <button class="btn btn-success" @click.prevent="addItem('mixs')">เพิ่มรายการ</button>
                        <button class="btn btn-danger" @click.prevent="deleteItem('mixs')">ลบรายการ</button>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('mixs')" v-model="isCheckedAll.mixs">
                            </th>
                            <th>ลำดับ</th>
                            <th width="80%">รายละเอียด</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(mix, index) in mixs" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.mixs" :value="index" @change="updateChecked('mixs')">
                            </td>
                            <td>{{ index + 1 }}</td>
                            <td>
                                <input type="text" class="form-control" v-model="mix.mix_desc">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row m-b">
                <div class="col-lg-6">
                    <h3>วิธีใช้</h3>
                </div>
                <div class="col-lg-6">
                    <div class="text-right">
                        <button class="btn btn-success" @click.prevent="addItem('instructions')">เพิ่มรายการ</button>
                        <button class="btn btn-danger" @click.prevent="deleteItem('instructions')">ลบรายการ</button>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('instructions')" v-model="isCheckedAll.instructions">
                            </th>
                            <th>ลำดับ</th>
                            <th width="80%">รายละเอียด</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(instruction, index) in instructions" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.instructions" :value="index" @change="updateChecked('instructions')">
                            </td>
                            <td>{{ index + 1 }}</td>
                            <td>
                                <input type="text" class="form-control" v-model="instruction.instruction_desc">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="searchForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ค้นหา</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">สายปรุง Flavor No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="qSimuFormulaNo">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">รายละเอียด</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="qDesc">
                            </div>
                        </div>
                        <div style="height: 300px; overflow: scroll;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Flavor No.</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="header in filterHeaders" :key="header.simu_formula_id" style="cursor: pointer" @click="onClickHeader(header.simu_formula_id)">
                                        <td>{{ header.simu_formula_no}}</td>
                                        <td>{{ header.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คัดลอกสูตร</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="errors.length">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </p>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">จากสูตร Flavor No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="header.simu_formula_no" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">เป็นสูตร Flavor No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="new_simu_formula_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8">
                                <button class="btn btn-primary" @click.prevent="onClickCopy"><i class="fa fa-check-circle-o"></i> ตกลง</button>
                                <button class="btn btn-danger" @click.prevent="closeCopyModal"><i class="fa fa-times"></i> ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ประวัติการแก้ไข Flavor No. {{ header.simu_formula_no }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="height: 300px; overflow: scroll;">
                            <table class="table" v-if="histories.length">
                                <thead>
                                    <tr>
                                        <th>ครั้งที่</th>
                                        <th>ผู้แก้ไข</th>
                                        <th>วันที่แก้ไข</th>
                                        <th>Field แก้ไข</th>
                                        <th>ข้อมูลเดิม</th>
                                        <th>ข้อมูลที่แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="history in histories" :key="history.id">
                                        <td>{{ history.edit_no }}</td>
                                        <td>{{ history.edit_by }}</td>
                                        <td>{{ history.edit_date }}</td>
                                        <td>{{ history.edit_field }}</td>
                                        <td>{{ history.old_data }}</td>
                                        <td>{{ history.new_data }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else>Flavor No. {{ header.simu_formula_no }} ไม่มีประวัติการแก้ไข</p>
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
    showRemoveLineConfirmationDialog,
} from "../../commonDialogs"

export default {
    props: ['auth_userid', 'auth_username', 'sysdate', 'header_data', 'raw_mate_data', 'uom_data'],
    mounted() {
        // console.log('mounted!!!');
    },
    data() {
        return {
            header: {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: this.sysdate,
                created_by: '',
                last_update_date: '',
                last_updated_by: '',
            },
            new_simu_formula_no: '',
            //
            headers: this.header_data,
            lines: [],
            mixs: [],
            instructions: [],
            isCheckedAll: {
                lines: false,
                mixs: false,
                instructions: false,
            },
            checkedItem: {
                lines: [],
                mixs: [],
                instructions: [],
            },
            totalActualCost: 0,
            // search form
            qSimuFormulaNo: '',
            qDesc: '',
            // select
            raw_mates: this.raw_mate_data,
            uoms: this.uom_data,
            loading: false,
            formLoading: false,
            histories: [],
            errors: [],
        }
    },
    computed: {
        filterHeaders() {
            return this.filterHeadersByNo(this.filterHeadersByDesc(this.headers))
        },
        updateTotalCost() {
            let totalActualCost = 0;
            this.lines.forEach(function(line) {
                if (line.actual_cost > 0) {
                    totalActualCost += parseFloat(line.actual_cost)
                }
            })
            return totalActualCost;
        },
    },
    methods: {
        filterHeadersByNo(headers) {
            if (!this.qSimuFormulaNo) return headers
            return headers.filter(header => header.simu_formula_no.indexOf(this.qSimuFormulaNo) >= 0)
        },
        filterHeadersByDesc(headers) {
            if (!this.qDesc) return headers
            return headers.filter(header => header.description.indexOf(this.qDesc) >= 0)
        },
        onClickHeader(headerId) {
            showLoadingDialog()
            axios.get('/api/pd/0002/' + headerId).then(response => {
                if (response.status == 200) {
                    swal.close()
                    this.setNewData(response.data)
                }
            }).catch(error => {
                console.log(error)
            })
            $('#searchForm').modal('hide')
            this.qSimuFormulaNo = ''
            this.qDesc = ''
        },

        checkedAll(itemType) {
            this.checkedItem[itemType] = []
            if (!this.isCheckedAll[itemType]) {
                for (var i in this[itemType]) {
                    this.checkedItem[itemType].push(parseInt(i))
                }
            }
        },

        updateChecked(itemType) {
            this.isCheckedAll[itemType] = (this.checkedItem[itemType].length === this[itemType].length)
        },

        addItem(itemType) {
            if (itemType === 'lines') {
                this[itemType].push({
                    raw_material_id: '',
                    raw_material_num: '',
                    description: '',
                    status: '',
                    price_per_unit: '',
                    uom: '',
                    actual_qty: '',
                    actual_uom: '',
                    actual_cost: '',
                })
            } else {
                this[itemType].push({
                    desc: ''
                })
            }
        },

        deleteItem(itemType) {
            showRemoveLineConfirmationDialog(this.checkedItem[itemType].length).then(result => {
                if (result) {
                    let removeId = []
                    let keyName = ''
                    for(var i in this.checkedItem[itemType]) {
                        if(itemType == 'lines') {
                            keyName = 'simu_formula_line_id'
                        }
                        if(itemType == 'mixs') {
                            keyName = 'mix_id'
                        }
                        if(itemType == 'instructions') {
                            keyName = 'instruction_id'
                        }
                        removeId.push(this[itemType][this.checkedItem[itemType][i]][keyName])
                    }
                    // sort value before remove item from array
                    this.checkedItem[itemType].sort(function(a,b) {
                        return b-a
                    })
                    if(removeId.length > 0){
                        axios.delete('/api/pd/0002', {
                            params: {
                                data_type: itemType,
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
                    
                    // loop for remove checked from array
                    for(var i in this.checkedItem[itemType]) {
                        this[itemType].splice(this.checkedItem[itemType][i], 1)
                    }
                    // clear checked
                    this.checkedItem[itemType] = []
                    if (this.isCheckedAll[itemType]) {
                        this.isCheckedAll[itemType] = !this.isCheckedAll[itemType]
                    }
                }
            })
            
                    
        },

        onChangeRawMaterialNum(index) {
            let itemCode = this.lines[index].raw_material_num
            let indexOfSelected = this.raw_mates.findIndex(arr => arr.item_code === itemCode)
            this.lines[index].raw_material_id = this.raw_mates[indexOfSelected].inventory_item_id
            this.lines[index].description = this.raw_mates[indexOfSelected].description
            this.lines[index].status = this.raw_mates[indexOfSelected].status
            this.lines[index].price_per_unit = this.raw_mates[indexOfSelected].price_per_unit
            this.lines[index].uom = this.raw_mates[indexOfSelected].uom
            this.lines[index].actual_uom = this.raw_mates[indexOfSelected].uom
        },

        updateActualCost(index) {
            this.lines[index].actual_cost = (this.lines[index].price_per_unit > 0 && this.lines[index].actual_qty > 0)? this.lines[index].price_per_unit * this.lines[index].actual_qty: '-'
        },

        onClickCreate() {
            this.header = {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: this.sysdate,
                created_by: '',
                last_update_date: '',
                last_updated_by: '',
            },
            this.lines = []
            this.mixs = []
            this.instructions = []
            this.isCheckedAll = {
                lines: false,
                mixs: false,
                instructions: false,
            },
            this.checkedItem = {
                lines: [],
                mixs: [],
                instructions: [],
            },
            this.totalActualCost = 0
        },
        validate() {
            let errors = []
            if (!this.header.simu_formula_no) {
                errors.push('สารหอม Flavor No.')
            }

            if(this.lines.length > 0) {
                this.lines.forEach(function(line) {
                    if (!line.actual_qty) {
                        errors.push('ปริมาณที่ใช้')
                    }
                    if (!line.actual_uom) {
                        errors.push('หน่วย')
                    }
                })
            }

            if(errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        onClickSave() {
            if(!this.validate()) {
                return;
            }

            showLoadingDialog()
            let params = {
                user_id: this.auth_userid,
                header: this.header,
                lines: this.lines,
                mixs: this.mixs,
                instructions: this.instructions,
            }

            if(this.header.simu_formula_id) {
                // UPDATE
                axios.put('/api/pd/0002/' + this.header.simu_formula_id, params).then(response => {
                    if (response.status == 200) {
                        showSaveSuccessDialog()
                        console.log(response)
                        this.last_update_date = response.data.header.last_update_date
                        this.setNewData(response.data)
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            } else {
                // CREATE
                axios.post('/api/pd/0002', params).then(response => {
                    if (response.status == 200) {
                        showSaveSuccessDialog()
                        this.last_update_date = response.data.header.last_update_date
                        this.headers.push(response.data.header)
                        this.setNewData(response.data)
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            }
        },
        onClickCopy() {
            let errors = []
            if (!this.header.simu_formula_id) {
                errors.push('สายปรุง Flavor No.')
            }
            if (!this.new_simu_formula_no) {
                errors.push('คุณยังไม่ได้ระบุสูตรใหม่')
            }

            if(errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }

            showLoadingDialog()
            let params = { 
                simu_formula_id: this.header.simu_formula_id,
                new_simu_formula_no: this.new_simu_formula_no,
                user_id: this.auth_userid,
            }
            axios.post('/api/pd/0002', params).then(response => {
                if (response.status == 200) {
                    showSaveSuccessDialog()
                    this.histories = []
                    this.new_simu_formula_no = ''
                    //
                    this.setNewData(response.data)
                    $('#copyModal').modal('hide')
                }
            }).catch(error => {
                console.log(error)
            })
        },
        closeCopyModal() {
            $('#copyModal').modal('hide')
        },
        setNewData(newData) {
            this.header = newData.header
            this.lines = newData.lines
            this.mixs = newData.mixs
            this.instructions = newData.instructions
            this.histories = newData.histories
        }
    },
}
</script>