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
                            {{ dashboard.attributes.name }}
                        </td>
                    
                        <td>
                            <router-link :to="{ name: 'ShowDashboard', params: { id: dashboard.id }}">
                                <input type="button" value="Show" class="btn btn-small btn-warning"  />
                            </router-link>
                            <router-link :to="{ name: 'EditDashboard', params: { id: dashboard.id }}">
                                <input type="button" value="Edit" class="btn btn-small btn-success">
                            </router-link>

                            <input type="button" value="Delete" class="btn btn-small btn-danger" v-on:click="deleteDashboard(dashboard.id)" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
    
</template>

<script>
        
    import { mapActions, mapGetters } from 'vuex';
    export default {
        mounted() {
            this.loadAllDashboards();
        },
        data() {
            return {
    
                
            };
        },
        methods: {
            ...mapActions({
                loadAllDashboards: 'dashboards/loadAll',
            }),

            deleteDashboard(id) {
                const Id = { id: id };
                this.$store.dispatch('dashboards/delete', Id); 
            },
                       
        },
        computed: {
            ...mapGetters({
              dashboards: 'dashboards/all',
            }),
        }
    }
        
</script>

<style scoped>
</style>
