
<template>
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center"> Dashboardd Configuration</h1>
            

            <div class="chartcontainer">

                <apexchart width="500" type="area" :options="options" :series="chartdata"></apexchart>
            
            </div>
            
            
             

        </div>
        <div class="col-md-4">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>

                <div class="form-group">
                    <label for="">Sensor</label>
                    <div>
                        <b-form-select v-model="dashboard_item.attributes.sensor_id"  @change="getSensorDataKeys"  :options="sensor_name_options" class="mb-3" />
                        <p  v-if="sensor_data">Tracked events : {{sensor_data.length}}</p>
                    </div>

                </div>

                <div class="form-group">
                    <label for="">Charts</label>
                    <div>
                        <b-form-select v-model="dashboard_item.attributes.chart_key" :options="chart_options" class="mb-3" />
                    </div>

                </div>
                <div v-if="dashboard_item.attributes.chart_key === 'line'" class="form-group">
                    <label for="">X-Axis</label> 
                    <div>
                        
                        <b-form-select multiple v-model="dashboard_item.attributes.sensor_data_key" :options="sensor_key_options" class="mb-3" />
                        
                    </div>

                </div>
<!--                <b-tabs>
                    <b-tab v-for="(item, index) in sensor_item.sensor_data_key.name" :title="item" :key="item" >
                    <div class="form-group">
                        <label for="name">Label</label>
                        <input class="form-control" :v-model="sensor_item.sensor_data_key[index].name" placeholder="name" />
                    </div>
                      <swatches-picker :v-model="sensor_item.sensor_data_key[index].colors" /> 
                    </b-tab>
                    

                </b-tabs>-->
                
                
                <div v-if="dashboard_item.chart_key === 'line'" class="form-group">
                    <label for="">Y-Axis</label>
                    <div>
                        <b-form-select v-model="dashboard_item.sensor_data_val" :options="sensor_val_options" class="" />
                    </div>

                </div>

                <input type="button" value="Delete" class="btn btn-small btn-danger" />
                <input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()" />

            </form>
        </div>
        <div class="col-md-12">
           
            <sensor-datatable v-if="dashboard_item.attributes.sensor_id > '0'" v-bind:sensor_id="dashboard_item.attributes.sensor_id"></sensor-datatable>
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
                        this.getDashboardItems(this.$route.params.sensor_id);
                        //this.getDashboardItemConfiguration(this.$route.params.dashboard_id,this.$route.params.sensor_id);
                        
                        this.loadDashboardItem({id:this.$route.params.item_id}).then(()=>{
                                
                                this.dashboard_item=this.getDashboardItem({id:this.$route.params.item_id});
                                this.getSensorKeyOptions(this.dashboard_item.attributes.sensor_id);
                        });
                        
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
                        colors:"",
                        sensor_data: [],
                        show: false,
                        sensor_data_key:[],
                  
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
                       
                        if (dashboard_item.id == 0)
                        {
                           

                        } else
                        {


                        }
                    },
                    getDashboardItemConfiguration(dashboard_id,sensor_id) {
                        
                        
                        
//                        let currentObj = this;
//                                                
//                        axios.get('/api/dashboard/'+dashboard_id+'/item/'+sensor_id, {})
//                                .then(function (response) {
//                                    
//                                    $.each(response.data, function (key, value) {
//
//                                         currentObj.sensor_item = response.data[0];
//                                    });
//                                    this.getSensorData(sensor_id);
//                                   
//                                })
//                                .catch(function (error) {
//                                    currentObj.output = error;
//                                });
                    }, 
                    //
                    getSensorKeyOptions(id) {

                        const filter = {
                            'group': true,
                            'sensor_id': id
                        }
                        
                        this.loadSensorDataKey({filter}).then(()=>{
                            const sensorDataKeys=this.getSensorDataKeys({filter});
                            for(let index in sensorDataKeys)
                            {   
                                console.log(sensorDataKeys[index]);
                            }
                            //currentObj.sensor_key_options.push({"value": response.data[key].key, "text": response.data[key].key});
                        });
                      
                    },


                    //get all Dashboard items 
                     getDashboardItems(sensor_id) {

                        let currentObj = this;

                        currentObj.options.id="vuechart-example";
                        
                        
//                        axios.get('/api/sensors/' + sensor_id + '/data', {})
//                            .then(function (response) {
//                                //currentObj.sensor_data = response.data;
//                                 
//                                $.each(response.data, function (key, value) {
//                                    currentObj.chartdata[0].name="humidity";
//                                    if(response.data[key].key=="humidity"){
//                                        let t= response.data[key].created_at.split(/[- :]/);
//                                        var d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
//                                        currentObj.chartdata[0].data.push([d, response.data[key].value]);
//                                    }
//                                   
//                                });
//                                
//
//                            })
//                            .catch(function (error) {
//                                currentObj.output = error;
//                            });

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
                            getSensorDataKeys: 'sensorDatas/where'
                            },


                    ),                    
                }
            }
</script>

<style scoped>
    .chartcontainer {
 
        width:400px;
        height: 300px;
        
    }
</style>
