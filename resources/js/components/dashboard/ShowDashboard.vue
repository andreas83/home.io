
<template>
    <div class="row">
       
        <div class=" col-md-4 col-sm-12  dbitem"   v-for="(item, index) in sensor_item_list">

            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id: item.id }}">
                <input type="button" value="Sensors" class="btn btn-small btn-success"  />
            </router-link>
 
            <apexchart width="500" :id="index" type="area" :options="item.options" :series="item.chartdata"></apexchart>

        </div>
        <pre>{{sensor_item_list}}</pre>



        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12  dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
    </div>
</div>

</template>


<script>
    import VueApexCharts from 'vue-apexcharts'
            export default {
                components: {'apexchart': VueApexCharts},
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

                            chart_key: "",

                        },
                        sensor_item_list: [
                            {
                                id: "",
                                sensor_id:"",
                                dashboard_id: 1,
                                sensor_data_key: "",
                                sensor_data_val: "",
                                created_at: "",
                                chartdata: [{
                                        name: 'series-1',
                                        data: []
                                    }],
                                options: {
                                    chart: {
                                        stacked: false,
                                        zoom: {
                                            type: 'x',
                                            enabled: true
                                        },
                                        toolbar: {
                                            autoSelected: 'zoom'
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            curve: 'smooth',
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },

                                    markers: {
                                        size: 0,
                                        style: 'full',
                                    },
                                    xaxis: {
                                        type: 'datetime',
                                    },
                                },

                                chart_key: "",

                            }
                        ],
                        sensor_data: {
                            key: "",
                            value: "",
                            created_at: ""

                        },

                    };
                },
                async mounted() {


                    this.getDashboardItems(1);


                },
                methods: {
                    //get all Dashboard items 
                    getDashboardItems(dashboard_id) {

                        let currentObj = this;
                        axios.get('/api/dashboard/' + dashboard_id + '/items/', {})
                                .then(function (response) {

                                    let init=currentObj.sensor_item_list;
                                    currentObj.sensor_item_list = response.data;
                                    
                                    $.each(response.data, function (key, value) {
                                        try {

                                            let sensor_item_key = key;
                                            currentObj.sensor_item_list[sensor_item_key].options=init[0].options;
                                            currentObj.sensor_item_list[sensor_item_key].chartdata=init[0].chartdata;
                                            
                                            axios.get('/api/sensors/' + response.data[key].sensor_id + '/data', {})
                                                    .then(function (response) {

                                                        console.log(key);
                                                        currentObj.sensor_item_list[sensor_item_key].chartdata[0].data = response.data.map(function (item)
                                                        {
                                                            let t = item.created_at.split(/[- :]/);
                                                            var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
                                                            
                                                            return [d, item.value];
                                                            
                                                        });

                                                        

                                                    }).map(key)
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
        min-height: 300px;
        border:1px #c5c5c5 dashed;
    }
</style>