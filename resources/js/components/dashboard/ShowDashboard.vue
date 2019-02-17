
<template>
    <div class="row">

        <div class=" col-md-4 col-sm-12  dbitem" v-if="loaded"   v-for="(item, index) in dashboard_item_list">

            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, item_id: item.id }}">
                <input type="button" value="Sensors" class="btn btn-small btn-success"  />
            </router-link>

            <apexchart width="500" :id="index" type="area" :options="item.options" :series="item.chartdata"></apexchart>

        </div>




        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, item_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12 dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, item_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
        <div class="col-md-4 col-sm-12  dbitem">
            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, item_id:0 }}">
                <input type="button" value="Sensors" class="btn btn-small btn-warning"  />
            </router-link>
        </div>
    </div>
</div>

</template>


<script>
    import VueApexCharts from 'vue-apexcharts';
    import { mapActions, mapGetters, mapSetters } from 'vuex';
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
                        dashboard_item_list: [
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

                    setTimeout(function(){ window.dispatchEvent(new Event('resize')); }, 3000);

                },
                methods: {
                  ...mapActions({

                      loadSensorData: 'sensorDatas/loadPage',

                      }
                  ),
                    //get all Dashboard items
                    getDashboardItems(dashboard_id) {
                      console.log(dashboard_id);
                      const filter = {
                        "dashboard_id": dashboard_id,
                        };
                        let currentObj = this;
                        this.$store.dispatch('dashboardItems/loadWhere', { filter }).then(() => {

                          currentObj.dashboard_item_list = this.$store.getters['dashboardItems/where']({ filter });

                          for(let index in currentObj.dashboard_item_list){
                            let sensor_id=currentObj.dashboard_item_list[index].attributes.sensor_id;
                            let sensor_data_key=currentObj.dashboard_item_list[index].attributes.sensor_data_key;
                            let chartData=[];
                            for(let key_index in sensor_data_key)
                            {
                                let sensor_key = Object.keys(sensor_data_key[key_index]);
                                sensor_key= sensor_key[0];

                                let sensor_name=sensor_data_key[key_index][sensor_key].name;

                                let prepare_chartdata={};
                                prepare_chartdata.name=sensor_name;
                                prepare_chartdata.data=this.getSensorData(sensor_id,sensor_key);
                                chartData.push(prepare_chartdata);
                            }

                            currentObj.dashboard_item_list[index].options={
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
                            }
                            currentObj.dashboard_item_list[index].chartdata=chartData;
                          }
                          this.loaded=true;

                        });
                    },
                    getSensorData(sensor_id,sensor_key){
                      const options = {
                          'page[number]': 1,
                          'page[size]': 300,
                          'filter[sensor_id]': sensor_id,
                          'filter[key]': sensor_key,
                          'sort' : "-created_at"
                        }
                        var page=[];
                        this.$store.dispatch('sensorDatas/loadPage', { options }).then(() => {
                            const sensorPageRaw = this.$store.getters['sensorDatas/page'];

                            for (var key in sensorPageRaw)
                            {
                                let t = sensorPageRaw[key].attributes.created_at.split(/[- :]/);
                                var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

                                page.push([
                                    d,
                                    sensorPageRaw[key].attributes.value,

                                  ]);
                            }
                          });
                          return page;
                    }

                },
                computed: {

                    ...mapGetters({


                            hasNext: 'sensorDatas/hasNext',
                            hasPrev: 'sensorDatas/hasPrevious',
                            },


                    ),
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
