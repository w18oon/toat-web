<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Vue</div>
                    <div class="card-body">
                        <p>I'm an example Vue.</p>
                        <input type="hidden" name="person_id" :value="person_id" autocomplete="off">
                        <el-select
                            v-model="person_id"
                            filterable
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
</template>

<script>
export default {
    props: ["personId", 'pDisabled'],
    data() {
        return {
            employees: [],
            person_id: (this.personId != undefined && this.personId != '') ? parseInt(this.personId) : '',
            loading: false,
            states: [],
            disabled: this.pDisabled ? true : false,
        };
    },
    mounted() {
        if (this.personId !== "") {
            this.getEmployees({ person_id: this.personId });
        } else {
            this.employees = [];
        }
    },
    methods: {
        remoteMethod(query) {
            if (query !== "") {
                this.getEmployees({ name: query });
            } else {
                this.employees = [];
            }
        },
    getEmployees(params) {
        this.loading = true;
        axios.get("/example/ajax/users", { params }).then(res => {
            let response = res.data
            this.loading = false;
            this.employees = response.data;
        });
    }
  }
};
</script>
