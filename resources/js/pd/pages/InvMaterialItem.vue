<template>
    <div>
        <form @submit.prevent="submitForm" ref="mainForm">
            <!-- <pre>
            {{ JSON.stringify({invMaterialItem,header_id,user}, null, 2) }}
        </pre> -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <!-- <form @submit.prevent="FreeProductsFormSubmit" ref="mainForm">  -->
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title col-lg-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-lg-6 align-middle">
                                        <h5>สร้างรหัสวัตถุดิบ - ยาเส้นปรุง/ยาเส้นพอง</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 text-right align-middle">
                                        <div class="text-right">
                                            <button class="btn btn-success" @click.prevent="createNew"><i
                                                    class="fa fa-plus"></i>&nbsp;สร้าง</button>
                                            <button class="btn btn-white" type="button" data-toggle="modal"
                                                data-target="#exampleModal" data-whatever="@getbootstrap"><i
                                                    class="fa fa-search" ></i>&nbsp;&nbsp;<span class="bold">ค้นหา</span>
                                            </button>

                                            <button class="btn btn-primary" type="submit">
                                                <strong><i class="fa fa-save"></i>&nbsp;&nbsp;บันทึก</strong>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="ibox-content">

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <label class="col-form-label">ประเภทวัตถุดิบ</label>
                                                    <div>
                                                        <ct-lookup class="" table="PtpditemTobaccoTypeV"
                                                            id_field="item_tobacco_type_code"
                                                            lookup_field="item_tobacco_type_desc"
                                                            :selected="invMaterialItem.raw_material_type_code"
                                                            @change="(val) => onInput('raw_material_type_code',val)">
                                                        </ct-lookup>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <label class="col-form-label">Blend No.</label>
                                                    <input class="form-control form-control-lg m-b" name="blend_num"
                                                        v-model="invMaterialItem.blend_num">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <label>รหัสสินค้า</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <!-- <input
                                                type="number"
                                                class="form-control"
                                                autocomplete="off"
                                                name="repair"
                                                :value="header.repair"
                                                :disabled="this.loading"
                                                @input="onHeaderInput('repair', {key:$event.target.value})"> -->
                                                    <input class="form-control form-control-lg m-b" name="item_code"
                                                        v-model="invMaterialItem.inventory_item_code"
                                                        disabled="disabled">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>รายละเอียด</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <!-- <input
                                                type="number"
                                                class="form-control"
                                                autocomplete="off"
                                                name="broken"
                                                :value="header.broken"
                                                :disabled="this.loading"
                                                @input="onHeaderInput('broken', {key:$event.target.value})"> -->

                                                    <input class="form-control form-control-lg m-b" name="description"
                                                        v-model="invMaterialItem.description">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!--  -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ค้นหา</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">ประเภทสินค้า:</label>
                                                <ct-lookup class="" table="PtpditemTobaccoTypeV"
                                                    id_field="item_tobacco_type_desc"
                                                    lookup_field="item_tobacco_type_desc"
                                                    :selected="invMaterialItem.raw_material_type"
                                                    @change="(val) => onInput('raw_material_type',val)">
                                                </ct-lookup>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">รหัสสินค้า:</label>
                                                <input type="text" class="form-control" id="recipient-name">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="recipient-name"
                                                            class="col-form-label">รายละเอียด:</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-primary btn-lg" >ค้นหา</button>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <label class="col-form-label">รหัสสินค้า</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <label class="col-form-label">รายละเอียด</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button> -->
                                        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script>
    // import { extractDataFormEvent,  copyObject  } from "../helpers";
    import {  instance as http } from "../httpClient";
    import {
        $route
    } from '../router';
    //import swal from 'sweetalert';


    function createInvmaterialItem(invMaterialItem) {
        return http.post($route('api.pd.inv-material-item.create'), {
            invMaterialItem
        })
    }

    function updateInvmaterialItem(id, invMaterialItem) {
        return http.put($route('api.pd.inv-material-item.update', { id }), {  invMaterialItem })
    }

    export default {
        metaInfo: {
            title: 'สร้างรหัสวัตถุดิบ - ยาเส้นปรุง/ยาเส้นพอง',
        },
        props: [
            'inv_material_item',
            'header_id',
            'user',
        ],
        data(){
            return {
                invMaterialItem: this.inv_material_item
            }
        },
        methods: {
            submitForm(){
                if(this.header_id){
                    this.$update(this.header_id,this.invMaterialItem)
                }else{
                    this.$create(this.invMaterialItem)
                }
            },

            onInput(col, o) {
                console.log(`onInput(${col})`, o, this.invMaterialItem[col])
                this.invMaterialItem[col] = o.key

                if (col === 'raw_material_type_code') {
                    this.invMaterialItem['raw_material_type'] = o.row.item_tobacco_type_desc
                    this.invMaterialItem['raw_material_type_code'] = o.row.item_tobacco_type_code
                }

                this.invMaterialItem = {...this.invMaterialItem}
            },
            $update(id, invmaterialItem) {
                console.log('$update', invmaterialItem)

                updateInvmaterialItem(id, invmaterialItem).then(({data}) => {
                    // alert('Success!')
                    swal({
                        title: "บันทึกข้อมูลสำเร็จ!",
                        icon: "success",
                        button: "ปิด",
                    });
                }).catch(err => {
                    console.error(err)
                    alert('Fail!: ' + err.toString())
                })
            },

             $create(invMaterialItem) {
                createInvmaterialItem(invMaterialItem).then(({data}) => {
                     console.log(data)
                   swal({
                        title: "บันทึกข้อมูลสำเร็จ!",
                        icon: "success",
                        button: "ปิด",
                    });
                }).catch(err => {

                    console.error(err)
                    alert('Fail!: ' + err.toString())
                })
             },
            //  $search(invMaterialItem){
            //      searchInvmaterialItem(invMaterialItem).then(({data}) => {
            //          console.log(data)
            //        swal({
            //             title: "บันทึกข้อมูลสำเร็จ!",
            //             icon: "success",
            //             button: "ปิด",
            //         });
            //     }).catch(err => {

            //         console.error(err)
            //         alert('Fail!: ' + err.toString())
            //     })

            //  },
            createNew() {
                window.location = $route('pd.inv-material-item.create')
            }

        }

    }

</script>

<style scoped>
    .el-select {
        width: 100% !important;
    }

    .ibox-title {
        padding: 20px;
    }

    .el-select-dropdown.el-popper {
        z-index: 9999;
    }

</style>
