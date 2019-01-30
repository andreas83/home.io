<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center">Dashboard Configuration</h1>

            <div></div>
        </div>
        <div class="col-md-6">
            <router-link :to="{ name: 'EditDashboard', params: { id: 0 }}">
                <input type="button" value="Add Dashboard" class="btn btn-small btn-success" >
            </router-link>

            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dashboard in dashboards">
                        <td>
                            {{ dashboard.id }}
                        </td>
                        <td>
                            {{ dashboard.name }}
                        </td>
                    
                        <td>
                            <router-link :to="{ name: 'AttachSensor', params: { id: dashboard.id }}">
                                <input type="button" value="Add Sensors" class="btn btn-small btn-warning"  />
                            </router-link>
                            <router-link :to="{ name: 'EditDashboard', params: { id: dashboard.id }}">
                                <input type="button" value="Edit" class="btn btn-small btn-success">
                            </router-link>

                            <input type="button" value="Delete" class="btn btn-small btn-danger" v-on:click="deleteDashboard(sensor.id)" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getDashboard();
        },
        data() {
            return {
                dashboards: "",
                
            };
        },
        methods: {
            
            getDashboard() {
                let currentObj = this;
                axios.get('/api/dashboards/', {})
                        .then(function (response) {
                            currentObj.dashboards = response.data;
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            },
            deleteDashboard(id) {

            }
        }
    }
</script>

<style scoped>
</style>
