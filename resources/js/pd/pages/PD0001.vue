<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right mb-3">
                <button :class="btn.create.class" @click="onClickCreate">
                    <i :class="btn.create.icon"></i> {{ btn.create.text }}
                </button>
                <button :class="btn.search.class" data-toggle="modal" data-target="#searchForm">
                    <i :class="btn.search.icon"></i> {{ btn.search.text }}
                </button>
                <button :class="btn.save.class" @click="onClickSave">
                    <i :class="btn.save.icon"></i> {{ btn.save.text }}
                </button>
                <button :class="btn.copyFormula.class" data-toggle="modal" data-target="#copyModal">
                    <i :class="btn.copyFormula.icon"></i> {{ btn.copyFormula.text }}
                </button>
                <button :class="btn.editHistory.class" data-toggle="modal" data-target="#historyModal">
                    <i :class="btn.editHistory.icon"></i> {{ btn.editHistory.text }}
                </button>
            </div>
            <div class="ibox">
                <div class="ibox-title">สารปรุง Casing</div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">สารปรุง Casing No. <span style="color: red;">*</span></label>
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
                                <label class="col-lg-4 col-form-label">วันที่สร้าง</label>
                                <div class="col-lg-8">
                                    <!-- <input type="text" class="form-control" v-model="header.creation_date" disabled> -->
<!--                                    <ct-datepicker-->
<!--                                        :disabled="true"-->
<!--                                        class="form-control my-1"-->
<!--                                        style="width: 200px;"-->
<!--                                        placeholder="โปรดเลือกวันที่"-->
<!--                                        :value="toJSDate(header.creation_date, 'yyyy-MM-dd')"-->
<!--                                        @change="(date) => {-->
<!--                                            if(date){-->
<!--                                                header.creation_date = jsDateToString(date)-->
<!--                                            }else{-->
<!--                                                header.creation_date = null-->
<!--                                            }-->
<!--                                        }"-->
<!--                                    />-->

                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input
                                        type="text"
                                        class="form-control"
                                        :disabled="true"
                                        :value="toThDateString(toJSDate(header.creation_date, 'yyyy-MM-dd'))">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่แก้ไขล่าสุด</label>
                                <div class="col-lg-7">
<!--                                    <ct-datepicker-->
<!--                                        :disabled="true"-->
<!--                                        class="form-control my-1"-->
<!--                                        style="width: 200px;"-->
<!--                                        placeholder="โปรดเลือกวันที่"-->
<!--                                        :value="toJSDate(header.last_update_date, 'yyyy-MM-dd')"-->
<!--                                        @change="(date) => {-->
<!--                                            if(date){-->
<!--                                                header.last_update_date = jsDateToString(date)-->
<!--                                            }else{-->
<!--                                                header.last_update_date = null-->
<!--                                            }-->
<!--                                        }" />-->

                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input
                                        type="text"
                                        class="form-control"
                                        :disabled="true"
                                        :value="toThDateString(toJSDate(header.last_update_date, 'yyyy-MM-dd'))" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">ผู้บันทึก</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="created_by" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right mb-3">
                <button :class="btn.add.class" @click.prevent="addItem('lines')">
                    <i :class="btn.add.icon"></i> {{ btn.add.text }}
                </button>
                <button :class="btn.deleteList.class" @click.prevent="deleteItem('lines')">
                    <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                </button>
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
                                    clearable
                                    filterable
                                    :filter-method="filterMethod"
                                    placeholder="ระบุรหัสวัตถุดิบ"
                                    :loading="loading"
                                    @change="onChangeRawMaterialNum(index)">
                                    <el-option
                                        v-for="option in options"
                                        :key="option.item_code"
                                        :label="option.item_code"
                                        :value="option.item_code">
                                        <span>{{ option.item_code }}</span> : <span>{{ option.description }}</span>
                                    </el-option>
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
                                <input type="number" class="form-control" v-model="line.actual_qty" @change="onChgUom(index)" min=0>
                            </td>
                            <td>
                                <el-select
                                    v-model="line.actual_uom"
                                    clearable
                                    filterable
                                    placeholder="ระบุหน่วย"
                                    :loading="loading"
                                    :disabled="line.raw_material_num == ''"
                                    @change="onChgUom(index)">
                                    <el-option
                                        v-for="uom in uoms(index)"
                                        :key="uom"
                                        :label="uom"
                                        :value="uom"></el-option>
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
                        <button :class="btn.add.class" @click.prevent="addItem('mixs')">
                            <i :class="btn.add.icon"></i> {{ btn.add.text }}
                        </button>
                        <button :class="btn.deleteList.class" @click.prevent="deleteItem('mixs')">
                            <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                        </button>
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
                        <button :class="btn.add.class" @click.prevent="addItem('instructions')">
                            <i :class="btn.add.icon"></i> {{ btn.add.text }}
                        </button>
                        <button :class="btn.deleteList.class" @click.prevent="deleteItem('instructions')">
                            <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                        </button>
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
                            <label class="col-lg-4 col-form-label">สารปรุง Casing No.</label>
                            <div class="col-lg-8">
                                <!-- <input type="text" class="form-control" v-model="qSimuFormulaNo"> -->
                                <el-select
                                    v-model="qSimuFormulaNo"
                                    clearable
                                    filterable
                                    placeholder="เลือกสารปรุง Casing No"
                                    :loading="loading">
                                    <el-option
                                        v-for="casingNo in casingNoList"
                                        :key="casingNo"
                                        :label="casingNo"
                                        :value="casingNo"></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">รายละเอียด</label>
                            <div class="col-lg-8">
                                <!-- <input type="text" class="form-control" v-model="qDesc"> -->
                                <el-select
                                    v-model="qDesc"
                                    clearable
                                    filterable
                                    placeholder="เลือกรายละเอียด"
                                    :loading="loading">
                                    <el-option
                                        v-for="desc in descList"
                                        :key="desc"
                                        :label="desc"
                                        :value="desc"></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8">
                                <button type="button" :class="btn.reset.class" @click.prevent="resetSearchForm">
                                    <i :class="btn.reset.icon"></i> {{ btn.reset.text }}
                                </button>
                                <button type="button" :class="btn.search.class" @click.prevent="submitSearchForm">
                                    <i :class="btn.search.icon"></i> {{ btn.search.text }}
                                </button>
                            </div>
                        </div>
                        <div style="height: 300px; overflow: scroll;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Casing No.</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="header in headers" :key="header.simu_formula_id" style="cursor: pointer" @click="onClickHeader(header.simu_formula_id)">
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
                            <label class="col-lg-4 col-form-label">จากสูตร Casing No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="header.simu_formula_no" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">เป็นสูตร Casing No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="new_simu_formula_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8">
                                <button type="button" :class="btn.ok.class" @click.prevent="onClickCopy">
                                    <i :class="btn.ok.icon"></i> {{ btn.ok.text }}
                                </button>
                                <button type="button" :class="btn.cancel.class" @click.prevent="closeCopyModal">
                                    <i :class="btn.cancel.icon"></i> {{ btn.cancel.text }}
                                </button>
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
                        <h5 class="modal-title">ประวัติการแก้ไข Casing No. {{ header.simu_formula_no }}</h5>
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
                            <p v-else>Casing No. {{ header.simu_formula_no }} ไม่มีประวัติการแก้ไข</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import {
    toJSDate,
    toThDateString,
    jsDateToString,
    isInRange
} from '../../dateUtils'
import { DateTime } from 'luxon'
import { showLoadingDialog, showValidationFailedDialog, showSaveSuccessDialog, showRemoveLineConfirmationDialog, } from '../../commonDialogs'

export default {
    props: ['btn', 'default_data', 'headers_data', 'raw_materials_data', 'uoms_data'],
    components: { 'ct-datepicker-th': DatePicker, },
    data() {
        return {
            luxon: { DateTime },
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            user_id: this.default_data.user_id,
            user_name: this.default_data.user_name,
            created_by: '',
            header: {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: new Date(),
                created_by: '',
                last_update_date: '',
                last_updated_by: '',
            },
            new_simu_formula_no: '',
            headers: this.headers_data,
            headers_copy: this.headers_data,
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
            qSimuFormulaNo: '',
            qDesc: '',
            loading: false,
            histories: [],
            errors: [],
            options: this.raw_materials_data,
        }
    },
    computed: {
        casingNoList() {
            return [...new Set(this.headers_copy.map(header => header.simu_formula_no))].sort()
        },
        descList() {
            return [...new Set(this.headers_copy.map(header => header.description))].sort()
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
        resetSearchForm() {
            this.qSimuFormulaNo = ''
            this.qDesc = ''
            this.headers = this.headers_copy
        },
        submitSearchForm() {
            if (this.qSimuFormulaNo !== '' || this.qDesc !== '') {
                this.headers = this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo || header.description == this.qDesc)
            }
        },
        onClickHeader(headerId) {
            showLoadingDialog()
            axios.get('/api/pd/0001/' + headerId).then(response => {
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
        filterMethod(query) {
            if (query !==  '') {
                this.options = this.raw_materials_data.filter(raw_material => {
                    return raw_material.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 || raw_material.description.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.options = this.raw_materials_data
            }
        },
        uoms(lineIdx) {
            let rawMaterialNum = this.lines[lineIdx].raw_material_num
            let rawMaterial = this.raw_materials_data.filter(raw_material => raw_material.item_code == rawMaterialNum)[0]
            if(rawMaterial) {
                let uoms_data = this.uoms_data.filter(uom => uom.inventory_item_id == rawMaterial.inventory_item_id && uom.organization_id == rawMaterial.organization_id)
                return [...new Set(uoms_data.map(uom => uom.code))].sort()
            }
            return []
        },
        onChgUom(lineIdx) {
            let line = this.lines[lineIdx]
            let rawMaterial = this.raw_materials_data.filter(raw_material => raw_material.item_code == line.raw_material_num)[0]
            let uom = this.uoms_data.filter(uom => uom.inventory_item_id == rawMaterial.inventory_item_id && uom.organization_id == rawMaterial.organization_id && uom.code == line.actual_uom)[0]
            this.lines[lineIdx].actual_cost = line.price_per_unit * uom.conversion_rate * line.actual_qty
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
                    actual_qty: 0,
                    actual_uom: '',
                    actual_cost: 0,
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
                        axios.delete('/api/pd/0001', {
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
            let raw_material = this.raw_materials_data.filter(raw_material => raw_material.item_code === itemCode)[0]
            this.lines[index].raw_material_id = raw_material.inventory_item_id
            this.lines[index].description = raw_material.description
            this.lines[index].status = raw_material.status
            this.lines[index].price_per_unit = raw_material.price_per_unit
            this.lines[index].uom = raw_material.uom
            this.lines[index].actual_uom = raw_material.uom
            this.onChgUom(index)
        },
        onClickCreate() {
            this.created_by = ''
            this.header = {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: new Date(),
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
                errors.push('สารปรุง Casing No.')
            } else {
                let headers = this.headers_copy.filter(header => header.simu_formula_no === this.header.simu_formula_no)
                if (this.header.simu_formula_id == '' && headers.length > 0) {
                    errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากชื่อสารปรุง Casing No. ซ้ำ')
                }
            }

            if (this.lines.length > 0) {
                this.lines.forEach(line => {
                    if (!line.actual_qty) {
                        errors.push('ปริมาณที่ใช้')
                    }
                    if (!line.actual_uom) {
                        errors.push('หน่วย')
                    }
                })
            }

            if (this.mixs.length > 0) {
                this.mixs.forEach(mix => {
                    if (!mix.mix_desc) {
                        errors.push('วิธีผสม')
                    }
                })
            }

            if (this.instructions.length > 0) {
                this.instructions.forEach(instruction => {
                    if (!instruction.instruction_desc) {
                        errors.push('วิธีใช้')
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
                user_id: this.user_id,
                header: this.header,
                lines: this.lines,
                mixs: this.mixs,
                instructions: this.instructions,
            }

            if(this.header.simu_formula_id) {
                // update existing data
                axios.put('/api/pd/0001/' + this.header.simu_formula_id, params).then(response => {
                    if (response.status == 200) {
                        showSaveSuccessDialog()
                        this.setNewData(response.data)
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            } else {
                // create new data
                axios.post('/api/pd/0001', params).then(response => {
                    if (response.status == 200) {
                        if(response.data.error_message) {
                            showValidationFailedDialog([response.data.error_message])
                        } else {
                            showSaveSuccessDialog()
                            this.setNewData(response.data)
                        }
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
                errors.push('สารปรุง Casing No.')
            }
            if (!this.new_simu_formula_no) {
                errors.push('คุณยังไม่ได้ระบุสูตรใหม่')
            } else {
                let headers = this.headers_copy.filter(header => header.simu_formula_no === this.new_simu_formula_no)
                if (headers.length > 0) {
                    errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากชื่อสารปรุง Casing No. ซ้ำ')
                }
            }

            if(errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }

            showLoadingDialog()
            let params = {
                simu_formula_id: this.header.simu_formula_id,
                new_simu_formula_no: this.new_simu_formula_no,
                user_id: this.user_id,
            }
            axios.post('/api/pd/0001', params).then(response => {
                if (response.status == 200) {
                    showSaveSuccessDialog()
                    this.new_simu_formula_no = ''
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
            if (newData.headers) {
                this.headers = newData.headers
                this.headers_copy = newData.headers
            }
            this.created_by = newData.created_by
            this.header = newData.header
            this.header.creation_date = new Date(newData.header.creation_date)
            this.header.last_update_date = new Date(newData.header.last_update_date)
            this.lines = newData.lines
            this.mixs = newData.mixs
            this.instructions = newData.instructions
            this.histories = newData.histories
        }
    },
}
</script>

<style scoped>
.mx-datepicker { width: inherit !important; }
</style>