<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center">Sensor Configuration</h1>

   
        </div>
        <div class="col-md-6">
            <router-link :to="{ name: 'EditSensor', params: { id: 0 }}">
                <input type="button" value="Add Sensor" class="btn btn-small btn-success" >
            </router-link>
            
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sensor</th>
                        <th scope="col">Location</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sensor in sensors">
                        <td>
                            {{ sensor.id}}
                        </td>
                        <td>
                            {{ sensor.attributes.name }}
                        </td>
                        <td>
                            {{ sensor.attributes.location }}
                        </td>
                        <td>
                            

                            <router-link :to="{ name: 'EditSensor', params: { id: sensor.id }}">
                                <input type="button" value="Edit" class="btn btn-small btn-success">
                            </router-link>

                            <input type="button" value="Delete" class="btn btn-small btn-danger" v-on:click="deleteSensor(sensor.id)" />
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
            this.loadAllSensors();
        },
        data() {
            return {
    
            };
        },
        methods: {
            ...mapActions({
                loadAllSensors: 'sensors/loadAll',
            }),
            
            
            deleteSensor(id) {
                const sensorId = { id: id };
                this.$store.dispatch('sensors/delete', sensorId);                
            }
        },
        computed: {
            ...mapGetters({
              sensors : 'sensors/all',
            }),
        }
    }
</script>

<style scoped>
</style>
