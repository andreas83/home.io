    <template>
	<div class="row">
	<div class="col-md-6">
		<h1 class="text-center"> Edit Sensor {{sensor.name}}</h1>
	</div>
	<div class="col-md-6">
	<form>
		<input type="button" value="Delete" class="btn btn-small btn-danger">
		<input type="button" value="Save" class="btn btn-small btn-success" v-on:click="save()">

		<div class="form-group">
			<label for="id">ID</label>
			<input class="form-control" id="id" v-model="sensor.id" disabled placeholder="id">
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input class="form-control" id="name" v-model="sensor.name" placeholder="name">
		</div>

		<div class="form-group">
			<label for="location">Location</label>
			<input class="form-control" id="location" v-model="sensor.location" placeholder="location">
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea class="form-control" id="location" v-model="sensor.description"></textarea>
		</div>

	</form>
	</div>
	</div>
    </template>

    <script>
        export default {
        mounted() {
	     this.getSensors();
        },
        data() {
            return {
              id: "",
              sensor: {
			id:"0",
			name:"test",
			location: "",
			description: ""
		}
            };
        },
        methods: {
	    save(){
		let currentObj = this;
		let sensor=currentObj.sensor;
		console.log(sensor);
		if(sensor.id==0)
		{
                axios.post('/api/sensors/', sensor)
                .then(function (response) {
                    currentObj.sensor = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

		}
		else
		{

                axios.put('/api/sensors/'+sensor.id, { 
			name:sensor.name, 
			location:sensor.location, 
			description: sensor.description  
		})
                .then(function (response) {
                    currentObj.sensor = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

		}
	    },
            getSensors() {
                let currentObj = this;
		if(this.$route.params.id==0){
			currentObj.sensor.id=0;
			currentObj.sensor.name="";
			return true;
		}
                axios.get('/api/sensors/'+this.$route.params.id, {    })
                .then(function (response) {
                    currentObj.sensor = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        }
    }
    </script>

    <style scoped>
    </style>
