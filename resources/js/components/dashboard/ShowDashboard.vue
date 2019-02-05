
<template>
    <div class="row">

        <div class=" col-md-4 col-sm-12  dbitem" v-if="loaded"   v-for="(item, index) in sensor_item_list">

            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id: item.id }}">
                <input type="button" value="Sensors" class="btn btn-small btn-success"  />
            </router-link>
        
            <apexchart width="500" :id="index" type="area" :options="item.options" :series="item.chartdata"></apexchart>

        </div>
       



        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:1 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:1 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12  dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, sensor_id:1 }}">
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
                        loaded:false,
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
                                sensor_id: "",
                                dashboard_id: 1,
                                sensor_data_key: "",
                                sensor_data_val: "",
                                created_at: "",
                                chartdata: [{
                                        name: '',
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
                    
                    setTimeout(function(){ window.dispatchEvent(new Event('resize')); }, 1000);

                },
                methods: {
                    //get all Dashboard items 
                    getDashboardItems(dashboard_id) {

                        let currentObj = this;
                        axios.get('/api/dashboard/' + dashboard_id + '/items/', {})
                                .then(function (response) {


                                    currentObj.sensor_item_list = response.data;

                                    $.each(response.data, function (key, value) {
                                        try {

                                            let sensor_item_key = key;
                                            
                                            currentObj.sensor_item_list[sensor_item_key].options = {
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
                                            };
                                            currentObj.sensor_item_list[sensor_item_key].chartdata = [{
                                                name: response.data[key].sensor_id,
                                                data: []
                                            }];
                                            currentObj.sensor_item_list[sensor_item_key].sensor_id=response.data[key].sensor_id;
                                            axios.get('/api/sensors/' + response.data[key].sensor_id + '/data', {})
                                                    .then(function (response) {

                                                    currentObj.sensor_item_list[sensor_item_key].chartdata[0].data = response.data.filter(function(item) {
                                                      
                                                        if (item.key === response.data[key].key) {
                                                          return false; 
                                                        }
                                                        return true;
                                                      }).map(function (item)
                                                        {
                                                            let t = item.created_at.split(/[- :]/);
                                                            var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
                                                            
                                                            return [d, item.value];
                                                           
                                                        });
                                                        
                                            
                                                                                                                    
                                                            
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