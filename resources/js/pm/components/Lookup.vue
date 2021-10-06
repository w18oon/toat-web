<template>
    <el-select
        filterable
        remote
        placeholder="ค้นหา"
        v-model="value"
        :name="name"
        :remote-method="remoteMethod"
        :loading="loading"
        :disabled="payloads ? Object.values(payloads).filter(val => val === undefined).length > 0 : false"
        @change="onChange">
        <el-option
            v-for="item in options"
            :key="item.i"
            :label="item.value"
            :value="item">
        </el-option>
    </el-select>
</template>

<script>
import {queryPD as lookup} from '../lookup'

function execOrValue(mayBeFunction) {
    if (typeof mayBeFunction === 'function') return mayBeFunction()
    return mayBeFunction
}

export default {
    props: [
        'table',
        'name',
        'selected',
        'id_field',
        'lookup_field',
        'payloads',
        'data',
    ],
    data() {
        return {
            options: [],
            value: null,
            loading: false,
        }
    },
    mounted() {
    },
    created() {
        if (typeof this.data === 'object' &&
            typeof this.data.key !== 'undefined' &&
            typeof this.data.value !== 'undefined' &&
            typeof this.data.row === 'object'
        ) {
            this.loading = true;

            let row = {
                i: 0,
                key: this.data.key,
                value: this.data.value,
                row: this.data.row,
            }
            this.options = [row]
            this.value = row
            this.onChange(row)

            this.loading = false;
        } else if (typeof this.selected !== 'undefined' && this.selected !== null) {
            this.loading = true;
            lookup.on(this.table).id(this.selected, this.id_field, this.lookup_field).then(({data}) => {
                this.loading = false;
                let row = {
                    i: 0,
                    key: data.key,
                    value: data.value,
                    row: data.row,
                }
                this.options = [row]
                this.value = row
                this.onChange(row)
                //console.log('pd-lookup.create() set init value', this.value)
            })
        } else {
            let payloads = execOrValue(this.payloads)
            lookup.on(this.table).search('', this.id_field, this.lookup_field, payloads).then(({data}) => {
                this.loading = false;
                let i = 0
                this.options = data.map(row => {
                    return {
                        i: i++,
                        key: row.key,
                        value: row.value,
                        row: row.row,
                    }
                })
            })
        }
    },
    methods: {
        remoteMethod(query) {
            let payloads = execOrValue(this.payloads)
            if (query !== '') {
                this.loading = true;
                lookup.on(this.table).search(`${query}`, this.id_field, this.lookup_field, payloads).then(({data}) => {
                    this.loading = false;
                    let i = 0
                    this.options = data.map(row => {
                        return {
                            i: i++,
                            key: row.key,
                            value: row.value,
                            row: row.row,
                        }
                    })
                })
            } else {
                this.options = [];
            }
        },
        onChange(key) {
            //console.log('onChange', {key})
            this.$emit('input', key)
            this.$emit('change', key)
        },
    }
}
</script>
