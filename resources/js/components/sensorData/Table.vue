<template>
    <div>
        <b-table v-if="hasNext" striped hover dark :items="sensorPage" @sort-changed="sortingChanged" no-local-sorting  :fields="fields"></b-table>
            <a class="btn btn-lg" v-if="hasPrev" v-on:click="loadNextPage(true)">Show prev Page</a>
            <a class="btn btn-lg" v-if="hasNext" v-on:click="loadNextPage(false)">Show next Page</a>
            <p  v-if="hasNext">Page:{{page}}</p>

    </div>
</template>
<script>
 import { mapActions, mapGetters, mapSetters } from 'vuex';

    export default {
        props: ['sensor_id'],
        name: "sensor-datatable",
        
        mounted() {

        this.setPageOptions();
        console.log(this.sensor_id);
        
        this.loadPage(
                {options:this.options}
        );


        },

        data() {
            return {
               
                options: {
                  'page[number]': 1,
                  'page[size]': "10",
                  'filter[sensor_id]': 1,
                  'sort' : "-created_at"
                },
               
                page: 1,
                pageSize:10,
                pageSort:"-created_at",
                
              
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
       
                    loadNext: 'sensors/loadNextPage',
                    loadPrev: 'sensors/loadPrevPage',
                    loadPage: 'sensorDatas/loadPage'
            }
            ),
            setPageOptions(){
                this.options = {
                    'page[number]': this.page,
                    'page[size]': this.pageSize,
                    'filter[sensor_id]': this.sensor_id,
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

                    sensorPageRaw: 'sensorDatas/page',

                    hasNext: 'sensorDatas/hasNext',
                    hasPrev: 'sensorDatas/hasPrevious',
                    },
             
            
            ),                    
        }
    }
</script>