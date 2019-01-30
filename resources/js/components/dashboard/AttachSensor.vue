
<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"> Dashboard Configuration</h1>
            <h3 class="text-center">1. Add Sensor to Dashboard </h3>
            
            {{sensor_items}}
        </div>
        <div class="col-md-6">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>

                <div class="form-group">
                    <label for="">Sensor</label>
                    <div>
                        <b-form-select v-model="sensor_item.sensor_id" @change="getSensorData" :options="sensor_name_options" class="mb-3" />
                        <p  v-if="sensor_data">Tracked events : {{sensor_data.length}}</p>
                    </div>

                </div>

                <div v-if="sensor_data.length>0" class="form-group">
                    <label for="">Charts</label>
                    <div>
                        <b-form-select v-model="sensor_item.chart_key" :options="chart_options" class="mb-3" />
                    </div>

                </div>
                <div v-if="sensor_item.chart_key === 'line'" class="form-group">
                    <label for="">X-Axis</label>
                    <div>
                        <b-form-select v-model="sensor_item.sensor_data_key" :options="sensor_key_options" class="mb-3" />
                    </div>

                </div>
                <div v-if="sensor_item.chart_key === 'line'" class="form-group">
                    <label for="">Y-Axis</label>
                    <div>
                        <b-form-select v-model="sensor_item.sensor_data_val" :options="sensor_val_options" class="mb-3" />
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
            this.getSensors();
            this.getDashboardItems(this.$route.params.id);
        },
        data() {
            return {
                id: "",
                sensor_item: {
                        id: "",
                        sensor_data_key: "",
                        sensor_data_val: "",
                        dashboard_id: this.$route.params.id,
                },
                sensor_items: {},
                sensor_data : "",
                show: false,
                sensor_name_options:[],
                sensor_key_options:[],
                sensor_val_options:[{value: "created_at", text: "created"},{value: "value", text: "value"}],
                chart_options:[{value:"line", text: "Line Chart"},{value:"bar", text: "Bar Chart"}],
            };
        },
        methods: {
            save() {
                let currentObj = this;
                let sensor_item = currentObj.sensor_item;
                
                if (sensor_item.id == 0)
                {
                    sensor_item.dashboard_id=this.$route.params.id;
                    axios.post('/api/dashboard/item', sensor_item)
                            .then(function (response) {
                                currentObj.sensor = response.data;
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
            getSensorKey(id) {
                let currentObj = this;

                axios.get('/api/sensors/' + id + '/data/key', {})
                        .then(function (response) {
                            currentObj.sensor_key_options=[];
                            $.each(response.data, function(key, value) {

                                currentObj.sensor_key_options.push({"value": response.data[key].key, "text": response.data[key].key});
                            });                    
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            },
            //get data of given sensors 
            getSensorData(id) {
                let currentObj = this;
                this.getSensorKey(id);
                axios.get('/api/sensors/' + id + '/data', {})
                        .then(function (response) {
                            currentObj.sensor_data=response.data;
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            },
            //get all sensors 
            getSensors() {
                
                let currentObj = this;
                axios.get('/api/sensors/', {})
                        .then(function (response) {
                            
                    
                            $.each(response.data, function(key, value) {

                                currentObj.sensor_name_options.push({"value": response.data[key].id, "text": response.data[key].name});
                            });
                            
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            },
            //get all Dashboard items 
            getDashboardItems(dashboard_id) {
                
                let currentObj = this;
                axios.get('/api/dashboard/'+dashboard_id+'/items/', {})
                        .then(function (response) {
                            
                    
                            currentObj.sensor_items=response.data;
                            
                        })
                        .catch(function (error) {
                            currentObj.output = error;
                        });
            },
            
           
        }
    }
</script>

<style scoped>
</style>
