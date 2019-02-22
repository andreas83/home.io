<template>
  <div>

    <apexchart  type="area" :options="chart.options" :series="chart.chartdata"></apexchart>
  </div>
</template>
<script>
  import VueApexCharts from 'vue-apexcharts';
  import { mapActions, mapGetters, mapSetters } from 'vuex';
  export default {
      props: ['dashboardItem'],
      name: "LineChart",
      components: {'apexchart': VueApexCharts},
      data() {
          return {

            chart:{
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
                      },

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
            }
          }
        },
        mounted() {

            this.prepare();
        },
      methods: {


        prepare(){


            let sensor_id=this.dashboardItem.attributes.sensor_id;
            let sensor_data_key=this.dashboardItem.attributes.sensor_data_key;
            let chartData=[];
            let color=[];
            for(let key_index in sensor_data_key)
            {

                let sensor_key = Object.keys(sensor_data_key[key_index]);

                sensor_key= sensor_key[0];

                let sensor_name=sensor_data_key[key_index][sensor_key].name;
                color.push(sensor_data_key[key_index][sensor_key].color.hex);
                let prepare_chartdata={};
                prepare_chartdata.name=sensor_name;

                prepare_chartdata.data=this.getSensorData(sensor_id,sensor_key);
                chartData.push(prepare_chartdata);
            }

            this.chart.options={
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
                colors: color,
                fill: {
                  colors:color
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
            this.chart.chartdata=chartData;

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
        },
        ...mapActions({

            loadSensorData: 'sensorDatas/loadPage',

            }
        ),
      },
      watch: {
           dashboardItem: function (val) {
             
              this.prepare();

            },
      },
    }
</script>
