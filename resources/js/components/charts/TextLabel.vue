<template>
  <div class="white">

    <b-list-group dark>

      <b-list-group-item v-for="(item, index) in txtData" :key="index" >{{item.name}}: {{item.data[0][1]}} ( {{item.data[0][0]}})</b-list-group-item>

  </b-list-group>
</div>
</template>
<script>
  import VueApexCharts from 'vue-apexcharts';
  import { mapActions, mapGetters, mapSetters } from 'vuex';
  export default {
      props: ['dashboardItem'],
      name: "TextLabel",

      data() {
          return {
            txtData:[]

          }
        },
        mounted() {

            this.prepare();
        },
      methods: {


        prepare(){


            let sensor_id=this.dashboardItem.attributes.sensor_id;
            let sensor_data_key=this.dashboardItem.attributes.sensor_data_key;
            let data=[];
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
                data.push(prepare_chartdata);
            }
            this.txtData=data;


        },

        getSensorData(sensor_id,sensor_key){
          const options = {
              'page[number]': 1,
              'page[size]': 1,
              'filter[sensor_id]': sensor_id,
              'filter[key]': sensor_key,
              'sort' : "-created_at"
            }
            var page=[];
            this.$store.dispatch('sensorDatas/loadPage', { options }).then(() => {
                const sensorPageRaw = this.$store.getters['sensorDatas/page'];

                for (var key in sensorPageRaw)
                {


                    page.push([
                        sensorPageRaw[key].attributes.created_at,
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
      }
    }
</script>
<style>
</style>
