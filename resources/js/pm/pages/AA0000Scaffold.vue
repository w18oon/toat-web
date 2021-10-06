<!--suppress ALL -->
<template>
    <form @submit.prevent="onSaveButtonClicked" ref="mainForm">
        <div>
            <div class="form-group row">
                              <pre class="col-lg-6" style="display: block">{{
                                      JSON.stringify({
                                          null
                                      }, null, 2)
                                  }}</pre>

                <pre class="col-lg-6" style="display: block">{{
                        JSON.stringify({
                            null
                        }, null, 2)
                    }}</pre>
            </div>


        </div>
    </form>
</template>

<script>


export default {
    created() {
        this.saveDataStage();
    },
    mounted() {
        this.setWarningBeforeUnload();
    },
    data() {
        return {
            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {},
    methods: {
        saveDataStage() {
            // this.dataStage = this.lodash.cloneDeep(this.data);
        },
        isDataStageChange() {
            return false;
            // console.debug('isDataStageChange', this.dataStage, this.data);
            //
            // let isEqual = this.lodash.isEuqal(this.dataStage, this.data);
            // console.debug(isEqual);
            //
            // //warning user if there is unsaved data
            // return !isEqual;
        },
        setWarningBeforeUnload() {
            warningBeforeUnload(() => {
                return this.isDataStageChange();
            });
        },
        clearWarningBeforeUnload() {
            window.onbeforeunload = null;
        },
    },
}
</script>
