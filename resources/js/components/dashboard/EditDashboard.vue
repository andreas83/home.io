<template>
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center"> Edit Dashboard {{dashboard.name}}</h1>
        </div>
        <div class="col-md-6">
            <b-alert variant="success" :show="show" dismissible>Saved</b-alert>
            <form>

                <div class="form-group">
                    <label for="id">ID</label>
                    <input class="form-control" id="id" v-model="dashboard.id" disabled placeholder="id" />
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" v-model="dashboard.attributes.name" placeholder="name" />
                </div>
                <div class="form-group">
                    <label for="name">Style</label>
                    <div>
                        <b-form-select v-model="dashboard.attributes.style" :options="options" class="mb-3" />
                    </div>

                </div>
                <input type="button" value="Delete" class="btn btn-small btn-danger" />
                <input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()" />

            </form>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters, mapSetters } from 'vuex';    
    export default {
        mounted() {
            this.dashboard.id=this.$route.params.id;
            this.$store.dispatch('dashboards/loadById', { id: this.dashboard.id })
            .then(() => {
              this.dashboard = this.$store.getters['dashboards/byId']({ id: this.dashboard.id });

            });
        },
        data() {
            return {
                id: "",
                dashboard: {
                    id: "0",
                    attributes: {
                        name: "",
                        style: "black"
                    }

                }
                , options: [
                    {value: "black", text: 'Black'},
                    {value: 'clean', text: 'Clean'},
                ],
                show: false
            };
        },
        methods: {
            save() {
       

                if (this.dashboard.id > 0)
                {
                    const dashboard = this.$store.getters['dashboards/byId']({ id: this.dashboard.id });
                    dashboard.attributes.name = this.dashboard.attributes.name;
                    dashboard.attributes.style = this.dashboard.attributes.style;
                    
                    const res= this.$store.dispatch('dashboards/update', dashboard).then(() => {
                        this.show=true;
                    });
                    
              

                } else
                {

                    const recordData = {
                        attributes: {
                          name: this.dashboard.attributes.name,
                          style: this.dashboard.attributes.style,
                          
                        },
                      };
                      
                    this.$store.dispatch('dashboards/create', recordData).then(() => {
                      
                        const dashboard = this.$store.getters['dashboards/lastCreated'];
                        this.dashboard=dashboard;
                        this.show=true;
                    });                    

                }
            },
            
        },
        computed: {
           
            ...mapGetters({
                    getDashboard: 'dashboard/byId',
                    createdDashboard: 'dashboard/lastCreated',
                    },
             
            
            ),                    
        }
    }
</script>

<style scoped>
</style>
