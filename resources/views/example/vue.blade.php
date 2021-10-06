@extends('layouts.app')

@section('title', 'Ex: Vue')

@section('page-title')
    <h2>Example: Vue</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Example</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Vue</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="#" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-center m-t-lg">
                        <user-component></user-component>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <user-component person-id="5" inline-template>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header text-center">Example Vue (inline-template)</div>
                                    <div class="card-body">
                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label text-right">Normal</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="person_id" :value="person_id" autocomplete="off">
                                                <el-select
                                                    v-model="person_id"
                                                    filterable
                                                    style="width: 100%"
                                                    remote
                                                    :disabled="disabled"
                                                    placeholder="ชื่อ หรือ นามสกุล"
                                                    :remote-method="remoteMethod"
                                                    :loading="loading"
                                                >
                                                    <el-option
                                                        v-for="empolyee in employees"
                                                        :key="empolyee.person_id"
                                                        :label="empolyee.full_name"
                                                        :value="empolyee.person_id"
                                                    ></el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </user-component>
                </div>
            </div>
        </div>
    </div>
@endsection
