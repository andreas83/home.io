
<template>
    <div class="row">

        <div class="col-lg-4 col-md-12 col-sm-12  dbitem"   v-for="(item, index) in dashboard_item_list">

            <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: 1, item_id: item.id }}">
                <input type="button" value="Sensors" class="btn btn-small btn-success flip"  />
            </router-link>

            <LineChart v-if ="loaded && item.attributes.chart_key==='line'" v-bind:dashboardItem="item"></LineChart>
            <BarChart v-if ="loaded && item.attributes.chart_key==='bar'" v-bind:dashboardItem="item"></BarChart>
            <TextLabel  v-if ="loaded && item.attributes.chart_key==='text'" v-bind:dashboardItem="item"></TextLabel>
            <Liquid  v-if ="loaded && item.attributes.chart_key==='liquid'" v-bind:dashboardItem="item"></Liquid>
        </div>

    </div>
</div>

</template>


<script>

    import { mapActions, mapGetters, mapSetters } from 'vuex';

            export default {

                data() {
                    return {
                        loaded:false,
                        id: "1",

                        dashboard: {
                            id: "0",
                            attributes: {
                                name: "",
                                style: "black"
                            }

                        },

                        dashboard_item_list: [
                            {
                                id: "",
                                sensor_id: "",
                                dashboard_id: 1,
                                sensor_data_key: "",
                                sensor_data_val: "",
                                created_at: "",
                                chart_key: "",

                            }
                        ],


                    };
                },
                mounted() {

                    this.id=this.$route.params.id;
                    this.$store.dispatch('dashboards/loadById', { id: this.id })
                    .then(() => {
                      this.dashboard = this.$store.getters['dashboards/byId']({ id: this.id });
                      this.$emit('style-change', this.dashboard.attributes.style)
                    });
                    this.getDashboardItems(this.id);

                },
                methods: {
                  ...mapActions({

                      loadSensorData: 'sensorDatas/loadPage',

                      }
                  ),
                    //get all Dashboard items
                    getDashboardItems(dashboard_id) {

                      const filter = {
                        "dashboard_id": dashboard_id,
                        };
                        let currentObj = this;
                        this.$store.dispatch('dashboardItems/loadWhere', { filter }).then(() => {

                          currentObj.dashboard_item_list = this.$store.getters['dashboardItems/where']({ filter });
                          currentObj.loaded=true;
                        });
                    },


                },
                computed: {

                    ...mapGetters({


                            hasNext: 'sensorDatas/hasNext',
                            hasPrev: 'sensorDatas/hasPrevious',
                            },


                    ),
                },
                watch:{
                  $route (to, from){
                      this.id=this.$route.params.id;
                      this.$store.dispatch('dashboards/loadById', { id: this.id })
                      .then(() => {
                        this.dashboard = this.$store.getters['dashboards/byId']({ id: this.id });
                        this.$emit('style-change', this.dashboard.attributes.style);
                      });
                      this.getDashboardItems(this.id);
                  }
                }
            }
</script>

<style>


    .dbitem{

      border:2px solid #00455e;

    	margin:10px;
      -webkit-box-shadow: 6px 11px 11px -2px rgba(0,69,94,1);
      -moz-box-shadow: 6px 11px 11px -2px rgba(0,69,94,1);
      box-shadow: 6px 11px 11px -2px rgba(0,69,94,1);

    }
</style>
