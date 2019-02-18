
<template>
    <div>
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center"> Dashboard Configuration</h1>


            <div class="chartcontainer">

               <LineChart v-if ="loaded" v-bind:dashboardItem="dashboard_item"></LineChart>

            </div>


        </div>
        <div class="col-md-4">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>

                <div class="form-group">
                    <label for="">Sensor</label>
                    <div>
                        <b-form-select v-model="dashboard_item.attributes.sensor_id"  @change="getItemConfig"  :options="sensor_name_options" class="mb-3" />

                    </div>

                </div>

                <div class="form-group">
                    <label for="">Charts</label>
                    <div>
                        <b-form-select v-model="dashboard_item.attributes.chart_key" :options="chart_options" class="mb-3" />
                    </div>

                </div>
                <div  class="form-group">
                    <label for="">X-Axis</label>
                    <div>

                        <b-form-select multiple v-model="selected_keys" :options="sensor_key_options"  class="mb-3" />

                    </div>

                </div>
                <b-tabs>
                    <b-tab v-if="loaded" v-for="(item, index) in selected_keys" :title="item" :key="item" >
                        <div class="form-group">
                            <label for="name">Label</label>

                           <input class="form-control" v-model="selected_values[item].name"  placeholder="" />
                        </div>
                        <div class="form-group">

                          <swatches-picker v-model="selected_values[item].color" />
                        </div>

                    </b-tab>


                </b-tabs>


                <div  class="form-group">
                    <label for="">Y-Axis</label>
                    <div>
                        <b-form-select v-model="dashboard_item.attributes.sensor_data_val" :options="sensor_val_options" class="" />
                    </div>

                </div>

                <input type="button" value="Delete" class="btn btn-small btn-danger" v-on:click="deleteDashboardItem()" />
                <input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()" />

            </form>
        </div>

    </div>
    <div class="row">
    <div class="col-md-12">

        <sensor-datatable v-if="dashboard_item.attributes.sensor_id > '0'" v-bind:sensor_id="dashboard_item.attributes.sensor_id"></sensor-datatable>
    </div>
    </div>
</div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts'

    import { Swatches } from 'vue-color'
    import { mapActions, mapGetters, mapSetters } from 'vuex';

            export default {
                name: 'ConfigureChart',
                components: {
                    'apexchart': VueApexCharts ,  'swatches-picker': Swatches
                },
                mounted() {
                    this.loaded = false;


                    this.loadAllSensors();



                    if(this.$route.params.item_id>0)
                    {


                        this.loadDashboardItem({id:this.$route.params.item_id}).then(()=>{

                                this.dashboard_item=this.getDashboardItem({id:this.$route.params.item_id});

                                for(let index in this.dashboard_item.attributes.sensor_data_key)
                                {

                                  let sensor_key=Object.keys(this.dashboard_item.attributes.sensor_data_key[index])[0];
                                  let sensor_name=this.dashboard_item.attributes.sensor_data_key[index][sensor_key].name;
                                  let sensor_color=this.dashboard_item.attributes.sensor_data_key[index][sensor_key].color;





                                  let config = { name : sensor_name, color: sensor_color }
                                  this.selected_values[sensor_key] = config;
                                  this.selected_keys.push(sensor_key);
                                }


                                this.loaded=true;
                                this.getSensorKeyOptions(this.dashboard_item.attributes.sensor_id);


                        });

                    }else{
                      console.log("xx"+this.sensor_key_options);
                    }

                },
                data() {
                    return {

                        id: "",
                        dashboard_item: {
                            id: "",
                            attributes:{
                                dashboard_id: "",
                                sensor_id:"",
                                sensor_data_key: [],
                                sensor_data_val: "",
                                created_at: "",
                            },


                        },
                        selected_keys:[],
                        selected_values:{},
                        colors:"",
                        sensor_data: [],
                        show: false,
                        sensor_data_key:[],
                        item:[],
                        sensor_key_options: [],
                        sensor_val_options: [{value: "created_at", text: "created"}, {value: "value", text: "value"}],
                        chart_options: [{value: "line", text: "Line Chart"}, {value: "bar", text: "Bar Chart"}],
                        loaded: false,
                        chartdata: [{
                            name: 'series-1',
                            data: []
                          }],
                        options:  {
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
                        items: null
                    };
                },


                methods: {
                    ...mapActions({
                        loadAllSensors: 'sensors/loadAll',
                        loadSensorDataKey: 'sensorDatas/loadWhere',
                        loadDashboardItem : 'dashboardItems/loadById'
                        }
                    ),
                    save() {
                        let currentObj = this;

                        let key_config=[];
                        for (let index in currentObj.selected_keys)
                        {
                          let key_name=currentObj.selected_keys[index];

                          key_config.push(
                            {
                               [key_name]:
                                {
                                  "name" : this.selected_values[key_name].name,
                                  "color" : this.selected_values[key_name].color
                                }
                            });

                        }


                        if (this.dashboard_item.id > 0)
                        {
                          const dashboardItem = this.$store.getters['dashboardItems/byId']({ id: this.dashboard_item.id });
                          dashboardItem.attributes.chart_key = this.dashboard_item.attributes.chart_key;
                          dashboardItem.attributes.sensor_id = this.dashboard_item.attributes.sensor_id
                          dashboardItem.attributes.sensor_data_key=key_config;




                          const res= this.$store.dispatch('dashboardItems/update', dashboardItem).then(() => {
                              this.show=true;
                          });

                        }
                        else
                        {
                          const recordData = {
                              attributes: {
                                sensor_id: this.dashboard_item.attributes.sensor_id,
                                dashboard_id: this.$route.params.dashboard_id,
                                chart_key: this.dashboard_item.attributes.chart_key,
                                sensor_data_key: key_config,
                                sensor_data_val: this.dashboard_item.attributes.sensor_data_val

                              },
                            };
                            this.$store.dispatch('dashboardItems/create', recordData).then(() => {
                              const dashboardItems = this.$store.getters['dashboardItems/lastCreated'];
                              this.dashboard_item=dashboardItems;
                          });
                        }
                    },

                    deleteDashboardItem() {
                        const Id = { id: this.dashboard_item.id };
                        this.$store.dispatch('dashboardItems/delete', Id);
                    },

                    getItemConfig(id){

                      this.getSensorKeyOptions(this.dashboard_item.attributes.sensor_id);
                    },

                    getSensorKeyOptions(id) {

                            let currentObj = this;
                            currentObj.sensor_key_options=[];
                            axios.get('/api/v1/sensorDatas/' + id + '/data/key', {})
                                .then(function (response) {
                                    currentObj.sensor_key_options = [];
                                    $.each(response.data, function (key, value) {

                                        currentObj.sensor_key_options.push({"value": response.data[key].key, "text": response.data[key].key});
                                        if(typeof currentObj.selected_values[response.data[key].key] === 'undefined')
                                        {
                                          currentObj.selected_values[response.data[key].key] = {name:"", color:""};
                                        }
                                    });
                                })
                                .catch(function (error) {
                                    currentObj.output = error;
                                });
                                this.loaded=true;
                    },




                },computed: {

                    sensor_name_options: function(){

                        let sensor_name_options=[];
                        for (let key in this.sensors){

                            sensor_name_options.push({"value": this.sensors[key].id, "text": this.sensors[key].attributes.name + " (" + this.sensors[key].attributes.location + ")"});

                        }
                        return sensor_name_options;
                    },
                    ...mapGetters({
                            sensors: 'sensors/all',
                            getDashboardItem: 'dashboardItems/byId',

                            },


                    ),
                }
            }
</script>

<style scoped>
  
</style>
