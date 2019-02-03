
<template>
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center"> Dashboard Configuration</h1>


            <div class="chartcontainer">

            <line-chart
                v-if="loaded"
                :chartdata="chartdata"
                :options="options"/>
            </div>

        </div>
        <div class="col-md-4">
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
        <div class="col-md-12">
            <pre>{{sensor_data}}</pre>
        </div>
    </div>
</template>

<script>
    import LineChart from '../Chart.vue'
            export default {
                name: 'ConfigureChart',
                components: {LineChart},
                mounted() {
                    this.loaded = false

                    this.getSensors();
                    this.getDashboardItems(this.$route.params.sensor_id);
                    if(this.$route.params.sensor_id>0)
                    {
                        this.getDashboardItemConfiguration(this.$route.params.dashboard_id,this.$route.params.sensor_id);
                    }
                   
                },
                data() {
                    return {

                        id: "",
                        sensor_item: {
                            id: "",
                            dashboard_id: this.$route.params.id,
                            sensor_data_key: "",
                            sensor_data_val: "",
                            created_at: "",
                            chartdata: {},
                            loaded: false,
                            chart_key: "",

                        },
                        sensor_data: "",
                        show: false,
                        sensor_name_options: [],
                        sensor_key_options: [],
                        sensor_val_options: [{value: "created_at", text: "created"}, {value: "value", text: "value"}],
                        chart_options: [{value: "line", text: "Line Chart"}, {value: "bar", text: "Bar Chart"}],
                        loaded: false,
                        chartdata: null,
                        options: null
                    };
                },
                methods: {
                    save() {
                        let currentObj = this;
                        let sensor_item = currentObj.sensor_item;

                        if (sensor_item.id == 0)
                        {
                            sensor_item.dashboard_id = this.$route.params.dashboard_id;
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

                            axios.put('/api/dashboard/item/', {
                                sensor_item })
                                    .then(function (response) {
                                     
                                    })
                                    .catch(function (error) {
                                        currentObj.output = error;
                                    });

                        }
                    },
                    getDashboardItemConfiguration(dashboard_id,sensor_id) {
                        let currentObj = this;
                        this.getSensorKeyOptions(sensor_id);
                        
                        axios.get('/api/dashboard/'+dashboard_id+'/item/'+sensor_id, {})
                                .then(function (response) {
                                    
                                    $.each(response.data, function (key, value) {

                                         currentObj.sensor_item = response.data[0];
                                    });
                                    this.getSensorData(sensor_id);
                                   
                                })
                                .catch(function (error) {
                                    currentObj.output = error;
                                });
                    },                    
                    getSensorKeyOptions(id) {
                        let currentObj = this;

                        axios.get('/api/sensors/' + id + '/data/key', {})
                                .then(function (response) {
                                    currentObj.sensor_key_options = [];
                                    $.each(response.data, function (key, value) {

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
                        this.getSensorKeyOptions(id);

                        axios.get('/api/sensors/' + id + '/data', {})
                                .then(function (response) {
                                    currentObj.sensor_data = response.data;

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


                                    $.each(response.data, function (key, value) {

                                        currentObj.sensor_name_options.push({"value": response.data[key].id, "text": response.data[key].name + " (" + response.data[key].location + ")"});
                                    });

                                })
                                .catch(function (error) {
                                    currentObj.output = error;
                                });
                    },
                    //get all Dashboard items 
                    async getDashboardItems(sensor_id) {

                        let currentObj = this;


                        currentObj.options = {responsive: true,};

                        currentObj.chartdata = {
                            labels: [],
                            datasets: [
                                {
                                    label: 'Temp',
                                    backgroundColor: '#f87979',
                                    data: []
                                },
                                {
                                    label: 'Luftfeuchtigkeit',
                                    backgroundColor: '#B0E0E6',
                                    data: []
                                },
                            ]

                        };

                        axios.get('/api/sensors/' + sensor_id + '/data', {})
                            .then(function (response) {
                                //currentObj.sensor_data = response.data;
                                $.each(response.data, function (key, value) {

                                    if (response.data[key].key == "temp")
                                    {
                                        currentObj.chartdata.labels.push(response.data[key].created_at);
                                        currentObj.chartdata.datasets[0].data.push(response.data[key].value);
                                    }
                                    if (response.data[key].key == "humidity")
                                    {
                                        currentObj.chartdata.datasets[1].data.push(response.data[key].value);
                                    }
                                });
                                currentObj.loaded = true;

                            })
                            .catch(function (error) {
                                currentObj.output = error;
                            });

                    },

                }
            }
</script>

<style scoped>
    .chartcontainer {
 
      
        height: 150px;
        
    }
</style>
