<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"> Edit Dashboard {{dashboard.name}}</h1>
        </div>
        <div class="col-md-6">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>

                <div class="form-group">
                    <label for="id">ID</label>
                    <input class="form-control" id="id" v-model="dashboard.id" disabled placeholder="id" />
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" v-model="dashboard.name" placeholder="name" />
                </div>
                <div class="form-group">
                    <label for="name">Style</label>
                    <div>
                        <b-form-select v-model="dashboard.style" :options="options" class="mb-3" />
                    </div>

                </div>
                <input type="button" value="Delete" class="btn btn-small btn-danger" />
                <input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()" />

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getDashboards();
        },
        data() {
            return {
                id: "",
                dashboard: {
                    id: "0",
                    name: "",
                    style: "black"

                }
                , options: [
                    {value: "black", text: 'Black'},
                    {value: 'clena', text: 'Clean'},
                ],
                show: false
            };
        },
        methods: {
            save() {
                let currentObj = this;
                let dashboard = currentObj.dashboard;

                if (dashboard.id == 0)
                {

                    axios.post('/api/dashboards/', dashboard)
                            .then(function (response) {
                                currentObj.dashboard = response.data;
                                currentObj.show = true;
                            })
                            .catch(function (error) {
                                currentObj.output = error;
                            });

                } else
                {

                    axios.put('/api/dashboards/' + dashboard.id, {
                        name: dashboard.name,

                    })
                            .then(function (response) {
                                currentObj.dashboard = response.data;
                                currentObj.show = true;
                            })
                            .catch(function (error) {
                                currentObj.output = error;
                            });

                }
            },
            getDashboards() {
                let currentObj = this;
                if (this.$route.params.id == 0) {
                    currentObj.dashboard.id = 0;
                    currentObj.dashboard.name = "";
                    return true;
                }
                axios.get('/api/dashboards/' + this.$route.params.id, {})
                        .then(function (response) {
                            currentObj.dashboard = response.data;
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            }
        }
    }
</script>

<style scoped>
</style>
