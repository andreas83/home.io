
<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"> Dashboard Configuration</h1>
            <h3 class="text-center">1. Add Sensor to Dashboard </h3>



          
            
                <div class="container"  v-for="item in sensor_items">
                 
                    <line-chart
                        v-if="item.loaded"
                        :chartdata="item.chartdata"
                        :options="item.options"/>
                </div>
             
           
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
    import LineChart from '../Chart.vue'
            export default {
                name: 'ConfigureChart',
                components: {LineChart},
                async mounted() {
                    this.loaded = false

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
                        sensor_items: [],
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
                            sensor_item.dashboard_id = this.$route.params.id;
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
                        this.getSensorKey(id);

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
                    async getDashboardItems(dashboard_id) {

                        let currentObj = this;
                        axios.get('/api/dashboard/' + dashboard_id + '/items/', {})
                                .then(function (response) {


                                    currentObj.sensor_items = response.data;
                                    $.each(response.data, function (key, value) {
                                        try {

                                            let sensor_item_key=key;
                                            currentObj.sensor_items[sensor_item_key].options = {responsive: true};

                                            currentObj.sensor_items[sensor_item_key].chartdata = {
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

                                            axios.get('/api/sensors/' + response.data[key].id + '/data', {})
                                                    .then(function (response) {
                                                        //currentObj.sensor_data = response.data;
                                                        $.each(response.data, function (key, value) {
                                                            
                                                            if(response.data[key].key=="temp")
                                                            {
                                                                currentObj.sensor_items[sensor_item_key].chartdata.labels.push(response.data[key].created_at);
                                                                currentObj.sensor_items[sensor_item_key].chartdata.datasets[0].data.push(response.data[key].value);
                                                            }
                                                            if(response.data[key].key=="humidity")
                                                            {
                                                                currentObj.sensor_items[sensor_item_key].chartdata.datasets[1].data.push(response.data[key].value);
                                                            }
                                                        });
                                                        currentObj.sensor_items[sensor_item_key].loaded = true;
                                                    })
                                                    .catch(function (error) {
                                                        currentObj.output = error;
                                                    });




                                        } catch (e) {
                                            console.error(e)
                                        }



                                    });
                                    
                                    currentObj.loaded=true;

                                })
                                .catch(function (error) {
                                    currentObj.output = error;
                                });
                    },

                }
            }
</script>

<style scoped>
    .container {
        float:left;
        max-width: 400px;
        max-height: 150px;
        margin:  23px auto;
    }
</style>
