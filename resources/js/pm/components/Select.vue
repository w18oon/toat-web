<template>
    <el-select
        v-model="model"
        :placeholder="placeholder"
        @change="onInput">
        <el-option
            v-for="item in options"
            :key="item.key"
            :label="item.value"
            :value="item">
        </el-option>
    </el-select>
</template>

<script>
export default {
    props: {
        options: {type: Array},
        placeholder: {type: String, default: 'เลือก'},
    },
    data() {
        return {
            model: null,
        }
    },
    mounted() {
    },
    created() {
    },
    methods: {
        onInput(item) {
            console.log('ct-select', item)
            this.$emit('input', item)
            this.$emit('change', item)
        },
    }
}
</script>
