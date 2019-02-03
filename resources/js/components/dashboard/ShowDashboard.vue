
<template>
    <div class="row">
   
        <div class=" col-md-4 dbitem"   v-for="item in sensor_item_list">
                
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id: item.id }}">
                <input type="button" value="Sensors" class="btn btn-small btn-success"  />
            </router-link>
            
            <line-chart
                v-if="loaded"
                :chartdata="item.chartdata"
                :options="item.options"/>
        </div>
        
          
        
        <div class="col-md-4 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
            </div>
    </div>

</template>


<script>
    import LineChart from '../Chart.vue'
            export default {
                components: {LineChart},
                data() {
                    return {

                        id: "",
                        sensor_item: {
                            id: "",
                            dashboard_id: 1,
                            sensor_data_key: "",
                            sensor_data_val: "",
                            created_at: "",
                            chartdata: {},
                            loaded: false,
                            chart_key: "",

                        },
                        sensor_item_list: [],
                        sensor_data: {
                            key:"",
                            value:"",
                            created_at:""
                           
                        },
                        
                        loaded: false,
                      
                      
                    };
                },
                async mounted() {
                    this.loaded = false

                    this.getDashboardItems(1);

                },
                methods: {
                    //get all Dashboard items 
                    async getDashboardItems(dashboard_id) {

                        let currentObj = this;
                        axios.get('/api/dashboard/' + dashboard_id + '/items/', {})
                                .then(function (response) {


                                    currentObj.sensor_item_list = response.data;
                                    $.each(response.data, function (key, value) {
                                        try {

                                            let sensor_item_key = key;
                                            currentObj.sensor_item_list[sensor_item_key].options = {responsive: true};
                                            currentObj.sensor_item_list[sensor_item_key].id=response.data[key].id;
                                            currentObj.sensor_item_list[sensor_item_key].chartdata = {
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
                                                       
                                                        $.each(response.data, function (key, value) {

                                                            if (response.data[key].key == "temp")
                                                            {
                                                                currentObj.sensor_item_list[sensor_item_key].chartdata.labels.push(response.data[key].created_at);
                                                                currentObj.sensor_item_list[sensor_item_key].chartdata.datasets[0].data.push(response.data[key].value);
                                                            }
                                                            if (response.data[key].key == "humidity")
                                                            {
                                                                currentObj.sensor_item_list[sensor_item_key].chartdata.datasets[1].data.push(response.data[key].value);
                                                            }
                                                        });
                                                        currentObj.loaded = true;
                                                        currentObj.sensor_item_list[sensor_item_key].loaded = true;
                                                        
                                                    })
                                                    .catch(function (error) {
                                                        currentObj.output = error;
                                                    });




                                        } catch (e) {
                                            console.error(e)
                                        }



                                    });





                                })
                                .catch(function (error) {
                                    currentObj.output = error;
                                });
                    }
                }
            }
</script>

<style scoped>
  
    .dbitem{
        width: 200px;
        min-height: 400px;
        border:1px #c5c5c5 dashed;
    }
</style>