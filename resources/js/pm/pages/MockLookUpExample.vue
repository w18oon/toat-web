<!--suppress ALL -->
<template>
    <form @submit.prevent="" ref="mainForm">
        <div>
            <div class="form-group row">
                            <pre class="col-lg-6" style="display: block">{{
                                    JSON.stringify({
                                        dataModel,
                                    }, null, 2)
                                }}</pre>

                <pre class="col-lg-6" style="display: block">{{
                        JSON.stringify({
                            inputModel,
                        }, null, 2)
                    }}</pre>
            </div>

            <div class="ibox ">
                <db-lookup
                    :remote-data-source="mockLookup"
                    v-model="dataModel"
                    key-field="id"
                    label-pattern="id: {$}, name: {$}"
                    :label-fields="['id', 'name']"
                    :search-keys="['id', 'name']"
                    :max-results="20"
                    @change="(item)=>{
                        inputModel = item.attr2;
                    }"
                >
                </db-lookup>

                <input
                    type="text"
                    v-model="inputModel"
                >
                </input>
            </div>

        </div>
    </form>
</template>

<script>

import {setAllObjectKeys, warningBeforeUnload} from "../helpers"
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';

export default {
    created() {
    },
    mounted() {
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },

            dataModel: null,
            inputModel: null,
        }
    },
    props: {},
    methods: {
        mockLookup() {
            let data = [
                {id: '1', name: 'TestName1', attr2: "attr1"},
                {id: '2', name: 'TestName2', attr2: "attr2"},
                {id: '3', name: 'TestName3', attr2: "attr3"},
                {id: '4', name: 'TestName4', attr2: "attr4"},
                {id: '5', name: 'TestName5', attr2: "attr5"},
                {id: '6', name: 'TestName6', attr2: "attr6"},
                {id: '7', name: 'TestName7', attr2: "attr7"},
                {id: '8', name: 'TestName8', attr2: "attr8"},
                {id: '9', name: 'TestName9', attr2: "attr9"},
                {id: '10', name: 'TestName10', attr2: "attr10"},
            ];

            return data;
        },
    },
}


</script>

<style scoped>

</style>
