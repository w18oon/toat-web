<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="mb-3 float-right">
                    <button class="btn btn-success" @click.prevent="store">
                        <i class="fa fa-plus"></i> สร้าง
                    </button>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#searchModal">
                        <i class="fa fa-search"></i> ค้นหา
                    </button>
                    <button type="submit" class="btn btn-primary" @click.prevent="update">
                        บันทึก
                    </button>
                    <button type="submit" class="btn btn-primary" @click.prevent="copy">
                        <i class="fa fa-copy"></i> คัดลอกสูตร
                    </button>
                    <button type="submit" class="btn btn-primary" @click.prevent="history">
                        ประวัติแก้ไข
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="ibox mb-2">
                    <div class="ibox-title">
                        <h5>จำลองและคำนวณต้นทุน</h5>
                    </div>
                    <div class="ibox-content">
                        <form>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-form-label">สารปรุง Flavor No.</label>
                                <div class="col-sm-4">
                                    <input type="text" v-model="header.simu_formula_no" class="form-control">
                                </div>
                                <label for="" class="col-md-1 col-form-label">วันที่สร้าง</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" autocomplete="off" v-model="header.creation_date">
                                </div>
                                <label for="" class="col-md-1 col-form-label">วันที่แก้ไขล่าสุด</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" autocomplete="off" v-model="header.last_update_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-form-label">รายละเอียด</label>
                                <div class="col-sm-4">
                                    <input type="text" v-model="header.description" class="form-control">
                                </div>
                                <label for="" class="col-md-1 col-form-label">ผู้บันทึก</label>
                                <div class="col-sm-5">
                                    <input type="text" v-model="header.created_by" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-form-label">หมายเหตุ</label>
                                <div class="col-sm-4">
                                    <input type="text" v-model="header.remark_formula" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 float-right">
                                        <button type="submit" class="btn btn-success" @click.prevent="addLineAdd()">
                                            <i class="fa fa-plus"></i> เพิ่มรายการ
                                        </button>
                                        <button type="submit" class="btn btn-danger" @click.prevent="removeLineAdd()">
                                            <i class="fa fa-remove"></i> ลบรายการ
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="15">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="selectAllA" value="" @change="checkAllLineAdd($event)">
                                                        <label class="form-check-label" for="selectAllA">เลือก</label>
                                                    </div>
                                                </th>
                                                <th>รหัสวัตถุดิบ</th>
                                                <th>รายละเอียดวัตถุดิบ</th>
                                                <th>สถานะ</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>ปริมาณที่ใช้</th>
                                                <th>หน่วย</th>
                                                <th>ต้นทุนวัตถุดิบที่ใช้</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(line,index) in lineAdd" :key="index" v-show="!lineAdd[index].remove">
                                                <td class="align-middle text-center">
                                                    <input type="checkbox" v-model="lineAdd[index].selected">
                                                </td>
                                                <td>
                                                    <ct-lookup table="PtpdRawMateFlavorV" id_field="item_code" lookup_field="item_code" @change="(val) => onLookup(index, val)" :selected="lineAdd[index].raw_material_num">
                                                    </ct-lookup>
                                                    <!--<input type="text" class="form-control">-->
                                                </td>
                                                <td>{{ lineAdd[index].description }}</td>
                                                <td>{{ lineAdd[index].status }}</td>
                                                <td>{{ lineAdd[index].price_per_unit }}</td>
                                                <td>
                                                    <input type="number" v-model="lineAdd[index].actual_qty" class="form-control">
                                                </td>
                                                <td>
                                                    <select name="" id="" class="custom-select">
                                                        <option></option>
                                                        <option value="">GMS</option>
                                                    </select>
                                                    <!--
                                                    <ct-lookup table="PtpmItemConvUomV" id_field="uom_code" lookup_field="unit_of_measure" :payloads="{organization_id:form.organization_id}" @change="(val) => onLookup('request_uom', val)" :selected="form.uom_code">
                                                    </ct-lookup>
                                                    -->
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right">รวมต้นทุนทั้งหมด</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h3>วิธีผสม</h3>
                                </div>
                                <div class="col">
                                    <div class="mb-3 float-right">
                                        <button type="submit" class="btn btn-success" @click.prevent="addLineMix()">
                                            <i class="fa fa-plus"></i> เพิ่มรายการ
                                        </button>
                                        <button type="submit" class="btn btn-danger" @click.prevent="removeLineMix()">
                                            <i class="fa fa-remove"></i> ลบรายการ
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="15">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="selectAllB" value="" @change="checkAllLineMix($event)">
                                                        <label class="form-check-label" for="selectAllB">เลือก</label>
                                                    </div>
                                                </th>
                                                <th width="10">ลำดับ</th>
                                                <th>รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(line,index) in lineMix" :key="index" v-show="!lineMix[index].remove">
                                                <td class="align-middle text-center">
                                                    <input type="checkbox" v-model="lineMix[index].selected">
                                                </td>
                                                <td class="align-middle text-center">{{ lineMix[index].mix_no }}</td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="lineMix[index].mix_desc">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h3>วิธีใช้</h3>
                                </div>
                                <div class="col">
                                    <div class="mb-3 float-right">
                                        <button type="submit" class="btn btn-success" @click.prevent="addLineIns()">
                                            <i class="fa fa-plus"></i> เพิ่มรายการ
                                        </button>
                                        <button type="submit" class="btn btn-danger" @click.prevent="removeLineIns()">
                                            <i class="fa fa-remove"></i> ลบรายการ
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="15">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="selectAllC" value="" @change="checkAllLineIns($event)">
                                                        <label class="form-check-label" for="selectAllC">เลือก</label>
                                                    </div>
                                                </th>
                                                <th width="10">ลำดับ</th>
                                                <th>รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(line,index) in lineIns" :key="index" v-show="!lineIns[index].remove">
                                                <td class="align-middle text-center">
                                                    <input type="checkbox" v-model="lineIns[index].selected">
                                                </td>
                                                <td class="align-middle text-center">{{ lineIns[index].instruction_no }}</td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="lineIns[index].instruction_desc">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="searchModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <form class="form-inline" @submit.prevent="searchProcessRequest">

                            <label class="my-1 mr-3" for="">เลขที่คำสั่งผลิต</label>
                            <input type="text" v-model="search.request_number" class="form-control my-1 mr-3">

                            <label class="my-1 mr-3" for="">สินค้าที่ผลิต</label>
                            <!-- <input type="text" v-model="search.item_number" class="form-control my-1 mr-3"> -->

                            <ct-lookup table="PtpmItemNumberV" id_field="inventory_item_id" class="my-1 mr-3" lookup_field="item_number" @change="(val) => onSearchLookup('inventory_item_id', val)" :selected="search.inventory_item_id">
                            </ct-lookup>


                            <label class="my-1 mr-3" for="">วันที่เริ่มผลิต</label>
                            <input type="date" v-model="search.request_date" class="form-control my-1 mr-3" autocomplete="off">

                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </form>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">เลขที่คำสั่งผลิต</th>
                                    <th scope="col">สินค้าที่ผลิต</th>
                                    <th scope="col">รายละเอียด</th>
                                    <th scope="col">จำนวนที่ผลิต</th>
                                    <th scope="col">หน่วยนับ</th>
                                    <th scope="col">วันที่เริ่มผลิต</th>
                                    <th scope="col">สถานะคำสั่งการผลิต</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
import {instance as http} from "../httpClient";
import {$route} from '../router'

export default {
    created: function () {

    },
    mounted() {

    },
    data() {
        return {
            header: {
                simu_formula_id : null,
                simu_formula_no : null,
                description : null,
                remark_formula : null,
                creation_date : (new Date()).toISOString().slice(0, 10),
                last_update_date : null,
                created_by : this.user.fnd_user_id,
                simu_type : null,
                program_code : null,
                created_by_id : null,
                updated_by_id : null,
                deleted_by_id: null,
                last_updated_by : null
            },
            lineAdd : [{
                selected:false,
                raw_material_num : null,
                description : null,
                status:null,
                price_per_unit:null,
                actual_qty : null,
                actual_uom : null,
                //actual_cost : null
                remove:false
            }],
            lineMix : [{
                selected:false,
                mix_desc : null,
                mix_no:1,
                remove:false
            }],
            lineIns : [{
                selected:false,
                instruction_desc : null,
                instruction_no:1,
                remove:false
            }],
        }
    },
    props: {
        user: Object,
    },
    methods: {
        store() {
            http.post($route('api.pd.flavor-no.store'), { header : this.header }).then(({data}) => {
                swal("สร้างเรียบร้อย", "ทำการสร้างข้อมูลเรียบร้อย", "success");
            }).catch(err => {
                this.errors = err;
            })
        },
        update() {
            http.put($route('api.pd.flavor-no.update', {id: this.header.simu_formula_id}), { header : this.header }).then(({data}) => {
                swal("อัปเดทเรียบร้อย", "ทำการอัปเดทข้อมูลเรียบร้อย", "success");
            }).catch(err => {
                this.errors = err;
            })
        },
        copy() {

        },
        history() {

        },
        checkAllLineAdd(e){
            for(let i=0;i<this.lineAdd.length;i++){
                if(!this.lineAdd[i].remove){
                    this.lineAdd[i].selected = e.target.checked;
                }
            }
        },
        addLineAdd() {
            this.lineAdd.push({
                selected:false,
                raw_material_num : null,
                description : null,
                status:null,
                price_per_unit:null,
                actual_qty : null,
                actual_uom : null,
                //actual_cost : null
                remove:false
            });
        },
        removeLineAdd() {
            for(let i=0;i<this.lineAdd.length;i++){
                if(this.lineAdd[i].selected){
                    this.lineAdd[i].remove = true;
                }
            }
        },
        checkAllLineMix(e){
            for(let i=0;i<this.lineMix.length;i++){
                if(!this.lineMix[i].remove){
                    this.lineMix[i].selected = e.target.checked;
                }
            }
        },
        addLineMix() {
            this.lineMix.push({
                selected:false,
                mix_desc : null,
                mix_no:null,
                remove:false
            });
            this.updateOrderMix();
        },
        removeLineMix() {
            for(let i=0;i<this.lineMix.length;i++){
                if(this.lineMix[i].selected){
                    this.lineMix[i].remove = true;
                }
            }
            this.updateOrderMix();
        },
        updateOrderMix(){
            var order = 1;
            for(let i=0;i<this.lineMix.length;i++){
                if(!this.lineMix[i].remove){
                    this.lineMix[i].mix_no = order;
                    order += 1;
                }
            }
        },
        checkAllLineIns(e){
            for(let i=0;i<this.lineIns.length;i++){
                if(!this.lineIns[i].remove){
                    this.lineIns[i].selected = e.target.checked;
                }
            }
        },
        addLineIns() {
            this.lineIns.push({
                selected:false,
                instruction_desc : null,
                instruction_no:null,
                remove:false
            });
            this.updateOrderIns();
        },
        removeLineIns() {
            for(let i=0;i<this.lineIns.length;i++){
                if(this.lineIns[i].selected){
                    this.lineIns[i].remove = true;
                }
            }
            this.updateOrderIns();
        },
        updateOrderIns(){
            var order = 1;
            for(let i=0;i<this.lineIns.length;i++){
                if(!this.lineIns[i].remove){
                    this.lineIns[i].instruction_no = order;
                    order += 1;
                }
            }
        },
        search() {

        },
        onLookup(index, o) {
            this.lineAdd[index].description = o.row.description;
            this.lineAdd[index].status = o.row.status;
            this.lineAdd[index].price_per_unit = o.row.price_per_unit;
        },
        /*
        onSearchLookup(field, o) {
            if(field == 'inventory_item_id'){
                this.search.inventory_item_id = o.row.inventory_item_id;
            }
        },
        searchProcessRequest(){
            axios.get($route('api.pm.request-process.search'), this.search).then(res => {
                let response = res.data
                this.loading = false;
                this.search_datas = response.data;
            });
        },
        store() {
            http.post($route('api.pm.request-process.store'), this.form).then(({data}) => {
                this.formReset();
            }).catch(err => {
                this.errors = err;
            })
        },
        update() {
            http.put($route('api.pm.request-process.update', {id: this.form.request_process_id}), this.form).then(({data}) => {

            }).catch(err => {
                this.errors = err;
            })
        },
        copy() {

        },
        history() {

        },
        formReset(){
            for (const prop in this.form) {
                this.form[prop] = null;
            }

            this.form.department_code = this.user.department_code;
        }*/
    },
}
</script>
<style scoped>
.el-select {
    display: block;
}
</style>
