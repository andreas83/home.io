<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"> Edit Sensor</h1>
            <sensor-datatable  v-bind:sensor_id="sensor.id"></sensor-datatable>
          
        </div>
        <div class="col-md-6">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>
                <input type="button" value="Delete" class="btn btn-small btn-danger" />
                <input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()">

                    <div class="form-group">
                        <label for="id">ID</label>
                        <input class="form-control" v-model="sensor.id" id="id" disabled placeholder="id">
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" v-model="sensor.attributes.name" id="name" placeholder="name">
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input class="form-control" v-model="sensor.attributes.location"  id="location" placeholder="location">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control"  v-model="sensor.attributes.description" id="location" ></textarea>
                    </div>

            </form>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters, mapSetters } from 'vuex';

    export default {
        mounted() {

         
        
        this.sensor.id=this.$route.params.id;
        this.setPageOptions();
        if(this.sensor.id>0)
        {
            this.$store.dispatch('sensors/loadById', { id: this.sensor.id })
            .then(() => {
              this.sensor = this.$store.getters['sensors/byId']({ id: this.sensor.id });

            });

            this.loadPage(
                    {options:this.options}
            );
        }

        },

        data() {
            return {
                options: {
                  'page[number]': 1,
                  'page[size]': "10",
                  'filter[sensor_id]': "",
                  'sort' : "-created_at"
                },
                sensor:{
                    id:"",
                    attributes:{
                        name: "",
                        location: "",
                        description: ""
                    }
                },
                page: 1,
                pageSize:10,
                pageSort:"-created_at",
                
                show: false,
                fields: [
                    {
                        key: 'id',
                        sortable: true
                    },
                    {
                        key: 'key',
                        sortable: true
                    },
                    {
                        key: 'value',
                        sortable: true
                    },
                    {
                        key: 'created_at',
                        sortable: true
                    }
                ]
            };
        },
        methods: {
            ...mapActions({
                    loadById: 'sensors/loadById',
                    loadNext: 'sensors/loadNextPage',
                    loadPrev: 'sensors/loadPrevPage',
                    loadPage: 'sensorDatas/loadPage'
            }
            ),
            setPageOptions(){
                this.options = {
                    'page[number]': this.page,
                    'page[size]': this.pageSize,
                    'filter[sensor_id]': this.sensor.id,
                    'sort' : this.pageSort
                  }
         
            },
            
            sortingChanged(ctx){
                
                let desc="";
                if(ctx.sortDesc)
                    desc="-";
                this.pageSort=desc+ctx.sortBy;
                this.setPageOptions();
                
                
                
                this.loadPage(
                         {options:this.options}
                 
                );
                
            },
            loadNextPage(goBack = false) {
                

                if (goBack)
                    this.page = this.page - 1;
                else
                    this.page = this.page + 1;
            
                this.setPageOptions();
               
                this.loadPage({options:this.options});

            },
            save(){
                if(this.sensor.id>0)
                {
                    const sensor = this.$store.getters['sensors/byId']({ id: this.sensor.id });
                    sensor.attributes.name = this.sensor.attributes.name;
                    sensor.attributes.location = this.sensor.attributes.location;
                    sensor.attributes.description = this.sensor.attributes.description;
                    const res= this.$store.dispatch('sensors/update', sensor).then(() => {
                        this.show=true;
                    });
                    
                }   
                else{
                    
                    const recordData = {
                        attributes: {
                          name: this.sensor.attributes.name,
                          location: this.sensor.attributes.location,
                          description: this.sensor.attributes.description,
                        },
                      };
                      
                    this.$store.dispatch('sensors/create', recordData).then(() => {
                      
                        const sensor = this.$store.getters['sensors/lastCreated'];
                        this.sensor=sensor;
                        this.show=true;
                    });
                     

                }
            }

        },
        computed: {
            sensorPage: function(){
              
                let page = [];
                for (var key in this.sensorPageRaw)
                {
                    
                    page.push({
                        value:this.sensorPageRaw[key].attributes.value, 
                        key:this.sensorPageRaw[key].attributes.key, 
                        id:this.sensorPageRaw[key].id, 
                        created_at:this.sensorPageRaw[key].attributes.created_at  });
                   
                }
                return page;
            },
            ...mapGetters({
                    getSensors: 'sensors/byId',
                    sensorPageRaw: 'sensorDatas/page',
                    createdSensor: 'sensors/lastCreated',
                    hasNext: 'sensorDatas/hasNext',
                    hasPrev: 'sensorDatas/hasPrevious',
                    },
             
            
            ),                    
        }
    }
</script>

<style scoped>
</style>
