<template>
    <div class="row">
        <div class="col-lg-12">
            <p class="text-right">
                <button class="btn btn-success" @click="resetForm"><i class="fa fa-plus"></i> สร้าง</button>
                <button class="btn btn-default" data-toggle="modal" data-target="#searchForm"><i
                    class="fa fa-search"></i> ค้นหา
                </button>
                <button class="btn btn-primary" @click="saveForm"><i class="fa fa-save"></i> บันทึก</button>
                <button class="btn btn-default" data-toggle="modal" data-target="#historyModal"><i
                    class="fa fa-file-text-o"></i> ประวัติแก้ไข
                </button>
            </p>
            <div class="ibox">
                <div class="ibox-title">ยาเส้นพอง</div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">รหัสสินค้า <span
                                    style="color: red;">*</span></label>
                                <div class="col-lg-9">
                                    <el-select
                                        :disabled="saved"
                                        v-model="header.inventoryItemCode"
                                        filterable
                                        remote
                                        placeholder="ระบุรหัสสินค้า"
                                        :loading="false"
                                        @change="onChangeLookupHeaders">
                                        <el-option
                                            v-for="lookupHeader in lookupHeaders"
                                            :key="lookupHeader.inventory_item_id"
                                            :label="lookupHeader.inventory_item_code"
                                            :value="lookupHeader.inventory_item_code">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">รายละเอียด</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" v-model="header.description" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">หมายเหตุ</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" v-model="header.remark">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่สร้าง</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" :value="toThDateString(header.createdAt)"
                                           disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่แก้ไขล่าสุด</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" :value="toThDateString(header.updatedAt)"
                                           disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">ผู้บันทึก</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="header.createdBy" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-right">
                <button class="btn btn-success" @click.prevent="addItem('lines')">เพิ่มรายการ</button>
                <button class="btn btn-danger" @click.prevent="deleteItem('lines')">ลบรายการ</button>
            </p>
            <div class="ibox">
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('lines')" v-model="isCheckedAll.lines">
                            </th>
                            <th>รหัสวัตถุดิบ</th>
                            <th>รายละเอียด</th>
                            <th>Lot</th>
                            <th>สัดส่วน (%)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(line, lineIdx) in lines" :key="lineIdx">
                            <td>
                                <input type="checkbox" v-model="checkedItem.lines" :value="lineIdx"
                                       @change="updateChecked('lines')">
                            </td>
                            <td>
                                <el-select
                                    v-model="line.inventory_item_code"
                                    filterable
                                    remote
                                    placeholder="ระบุรหัสวัตถุสินค้า"
                                    :loading="false"
                                    @change="onChangeLookupLines(lineIdx)">
                                    <el-option
                                        v-for="lookupLine in lookupLines"
                                        :key="lookupLine.inventory_item_id"
                                        :label="lookupLine.inventory_item_code"
                                        :value="lookupLine.inventory_item_code">
                                    </el-option>
                                </el-select>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.description" disabled>
                            </td>
                            <td>
                                <el-select
                                    v-model="line.lot_number"
                                    filterable
                                    remote
                                    placeholder="ระบุ Lot Number"
                                    :loading="false"
                                    :disabled="line.inventory_item_code == ''">
                                    <el-option
                                        v-for="lookupLotNumber in filterLotNumber(line.inventory_item_code)"
                                        :key="lookupLotNumber.lot_number"
                                        :label="lookupLotNumber.lot_number"
                                        :value="lookupLotNumber.lot_number">
                                    </el-option>
                                </el-select>
                            </td>
                            <td>
                                <input
                                    style="text-align: right;"
                                    type="number"
                                    class="form-control"
                                    v-model="line.item_ratio" min="1">
                            </td>
                        </tr>
                        <tr v-if="lines.length > 0">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right; padding-right: 32px;">{{
                                totalItemRatio ? totalItemRatio : ''
                                }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="searchForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
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
                            <label class="col-lg-4 col-form-label">รหัสสินค้า</label>
                            <div class="col-lg-8">
                                <!--                                <input type="text" class="form-control" v-model="qCode">-->
                                <db-lookup
                                    table-name="PtpdExpandedTobaccoHLookup"
                                    v-model="qCode"
                                    key-field="inventory_item_code"
                                    value-field="inventory_item_code"
                                    label-pattern="{$}"
                                    :label-fields="['inventory_item_code']"
                                    :search-keys="['inventory_item_code']"
                                    :max-results="20"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">รายละเอียด</label>
                            <div class="col-lg-8">
                                <!--                                <input type="text" class="form-control" v-model="qDesc">-->
                                <db-lookup
                                    table-name="PtpdExpandedTobaccoHLookup"
                                    v-model="qDesc"
                                    key-field="description"
                                    value-field="description"
                                    label-pattern="{$}"
                                    :label-fields="['description']"
                                    :search-keys="['description']"
                                    :max-results="20"/>
                            </div>
                        </div>
                        <button
                            type="button"
                            :class="btn_trans.reset.class"
                            @click.prevent="()=>{
                                qCode = null
                                qDesc = null
                                headers = []
                            }">
                            <i :class="btn_trans.reset.icon"></i>
                            {{ btn_trans.reset.text }}
                        </button>
                        <button
                            value="ค้นหา"
                            type="submit"
                            :class="btn_trans.search.class"
                            @click.prevent="searchHeader">
                            <i :class="btn_trans.search.icon"></i>
                            {{ btn_trans.search.text }}
                        </button>

                        <div style="height: 300px; overflow: scroll;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>รายละเอียด</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="header in filterHeaders" :key="header.exp_tobacco_id" style="cursor: pointer"
                                    @click="() => {
                                        saved = true
                                        swal.close()
                                        selectHeader(header.exp_tobacco_id)
                                    }">
                                    <td>{{ header.inventory_item_code }}</td>
                                    <td>{{ header.description }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ประวัติการแก้ไขยาเส้นพอง {{ header.inventoryItemCode }}</h5>
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
                            <p v-else>ยาเส้นพอง {{ header.inventoryItemCode }} ไม่มีประวัติการแก้ไข</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    showValidationFailedDialog,
    showLoadingDialog,
    showSimpleConfirmationDialog,
} from "../../commonDialogs"
import * as Validator from 'validatorjs';
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils"
import {toThDateString} from "../../dateUtils";

import _get from 'lodash/get'
import {$route, api_pd_0009_search} from '../router'

export default {
    props: [
        'data',
        'init_header',
        'btn_trans',
    ],
    data() {
        return {
            swal,
            toThDateString,
            headers: this.data.headers,
            header: {
                ...{
                    id: '',
                    description: '',
                    inventoryItemCode: '',
                    inventoryItemId: '',
                    remark: '',
                    createdAt: this.data.createdAt,
                    createdBy: '',
                    updatedAt: '',
                },
                ...this.init_header,
            },
            lines: [],
            histories: [],
            // checked
            checkedItem: {
                lines: [],
            },
            isCheckedAll: {
                lines: false,
            },
            //searchForm
            qCode: '',
            qDesc: '',
            //lookup
            lookupHeaders: this.data.lookupHeaders,
            lookupLines: this.data.lookupLines,

            saved: !!_get(this.init_header, 'id', false),
        }
    },
    mounted() {
        console.log(this.data)
        // this.validate()
    },
    computed: {
        filterHeaders() {
            //return this.filterHeadersByNo(this.filterHeadersByDesc(this.headers))
            return this.headers
        },
        totalItemRatio() {
            const floatOrZero = (number) => !number || isNaN(number) ? 0 : parseFloat(number)
            return this.lines.reduce((acc, line) => acc + floatOrZero(line.item_ratio), 0)
        },
    },
    methods: {
        searchHeader() {
            showLoadingDialog()
            axios.get($route(api_pd_0009_search), {
                params: {
                    inventory_item_code: this.qCode,
                    description: this.qDesc,
                }
            }).then(({data}) => data).then(({headers}) => {
                swal.close()
                this.headers = headers
            }).catch(error => {
                console.log(error)
            })
        },
        filterHeadersByDesc(headers) {
            if (!this.qDesc) return headers
            // return headers.filter(header => header.description.indexOf(this.qDesc) >= 0)
            return headers.filter(header => header.description.includes(this.qDesc))
        },
        filterHeadersByNo(headers) {
            if (!this.qCode) return headers
            return headers.filter(header => header.inventory_item_code.includes(this.qCode))
        },
        filterLotNumber(itemCode) {
            return this.lookupLines.filter(lookup => lookup.inventory_item_code.includes(itemCode))
        },
        setterData(data) {
            // console.log('header => ' + data.header)
            this.header = {
                id: data.header.exp_tobacco_id,
                description: data.header.description,
                inventoryItemCode: data.header.inventory_item_code,
                inventoryItemId: data.header.inventory_item_id,
                remark: data.header.remark,
                createdAt: data.header.created_at,
                createdBy: data.header.created_by,
                updatedAt: data.header.updated_at,
            }
            if (data.headers) {
                this.headers = data.headers
            }
            // console.log('lines => ' + data.lines)
            this.lines = data.lines
            // console.log('histories => ' + data.histories)
            this.histories = data.histories
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
            this.isCheckedAll[itemType] = this.checkedItem[itemType].length === this[itemType].length
        },
        addItem(itemType) {
            this[itemType].push({
                exp_tobacco_line_id: '',
                inventory_item_code: '',
                inventory_item_id: '',
                description: '',
                item_ratio: '',
                lot_number: '',
            })
        },
        async deleteItem(itemType) {

            let confirmToDelete = await showSimpleConfirmationDialog('คุณต้องการลบรายการที่คุณเลือก')
            if (confirmToDelete) {
                // sort value before remove item from array
                this.checkedItem[itemType].sort(function (a, b) {
                    return b - a
                })
                let deleteLines = []

                for (var i in this.checkedItem[itemType]) {
                    if (this[itemType][i].exp_tobacco_line_id != '') {
                        // console.log('exp_tobacco_line_id => ' + this[itemType][i].exp_tobacco_line_id)
                        deleteLines.push(this[itemType][i].exp_tobacco_line_id)
                    }
                }

                // loop for remove checked from array
                for (var i in this.checkedItem[itemType]) {
                    this[itemType].splice(this.checkedItem[itemType][i], 1)
                }

                showLoadingDialog()
                if (deleteLines.length > 0) {
                    axios.delete('/api/pd/expanded-tobacco/' + this.header.id, {
                        data: {
                            lines: deleteLines
                        }
                    }).then(response => {
                        if (response.status == 200) {
                            console.log(response)
                        }
                    }).catch(error => {
                        console.log(error)
                    })
                }

                // clear checked
                this.checkedItem[itemType] = []
                if (this.isCheckedAll[itemType]) {
                    this.isCheckedAll[itemType] = !this.isCheckedAll[itemType]
                }
            }
        },
        selectHeader(headerId) {
            console.log('selectHeader | simuFormulaId => ' + headerId)
            showLoadingDialog()
            axios.get('/api/pd/expanded-tobacco/' + headerId).then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.setterData(response.data)
                }
            }).catch(error => {
                console.log(error)
            })
            // close modal && clear query
            $('#searchForm').modal('hide')
            this.qCode = ''
            this.qDesc = ''
        },
        headerValidation() {
            return {
                inventoryItemCode: 'required',
            }
        },
        lineValidationRule() {
            return {
                inventory_item_code: 'required',
                lot_number: 'required',
                item_ratio: 'required',
            }
        },
        validate() {
            let errors = []

            if (this.totalItemRatio !== 100) {
                errors.push('ระบุสัดส่วนไม่ถูกต้อง')
            }

            if(this.lines.filter(it => !it.item_ratio || !it.lot_number).length > 0) {
                errors.push('ต้องระบุ Lot และ สัดส่วน')
            }

            if (!this.header.inventoryItemCode) {
                errors.push('รหัสสินค้า')
            }

            if (this.lines.length == 0) {
                errors.push('ข้อมูลระดับ line')
            }

            if (errors.length > 0) {
                showValidationFailedDialog(errors)
            }

            return true
        },
        resetForm() {
            showLoadingDialog()
            window.location.reload(false)
            // this.header = {
            //     id: '',
            //     description: '',
            //     inventoryItemCode: '',
            //     inventoryItemId: '',
            //     remark: '',
            //     createdAt: this.data.createdAt,
            //     createdBy: '',
            //     updatedAt: '',
            // }
        },
        saveForm() {
            if (!this.validate()) {
                return;
            }
            let params = {
                description: this.header.description,
                inventoryItemCode: this.header.inventoryItemCode,
                inventoryItemId: this.header.inventoryItemId,
                remark: this.header.remark,
                lines: this.lines,
            }

            showLoadingDialog()
            if (this.header.id) {
                // console.log('Call API Put')
                axios.put('/api/pd/expanded-tobacco/' + this.header.id, params).then(response => {
                    if (response.status == 200) {
                        this.setterData(response.data)
                        // console.log(response.data)
                        this.saved = true
                    }
                }).catch(error => {
                    console.log(error)
                })
            } else {
                // console.log('Call API Post')
                axios.post('/api/pd/expanded-tobacco', params).then(response => {
                    if (response.status == 200) {
                        this.setterData(response.data)
                        // console.log(response)
                        this.saved = true
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        onChangeLookupHeaders() {
            let idx = this.lookupHeaders.findIndex(arr => arr.inventory_item_code == this.header.inventoryItemCode)
            this.header.inventoryItemId = this.lookupHeaders[idx].inventory_item_id
            this.header.description = this.lookupHeaders[idx].description
        },
        onChangeLookupLines(lineIdx) {
            let idx = this.lookupLines.findIndex(arr => arr.inventory_item_code == this.lines[lineIdx].inventory_item_code)
            this.lines[lineIdx].inventory_item_id = this.lookupLines[idx].inventory_item_id
            this.lines[lineIdx].description = this.lookupLines[idx].description
        }
    },
}
</script>
