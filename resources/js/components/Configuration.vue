    <template>
<div class="row">
<div class="col-md-6">
	<h1 class="text-center">Sensor Configuration</h1>

	<div><pre>{{ rawData }}</pre></div>
</div>
<div class="col-md-6">
<router-link :to="{ name: 'edit', params: { id: 0 }}">
    <input type="button" value="Add Sensor" class="btn btn-small btn-success" >
</router-link>

<table class="table table-hover table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Sensor</th>
      <th scope="col">Location</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="sensor in sensors">
	<td>
		    {{ sensor.id}}
	</td>
	<td>
		    {{ sensor.name }}
	</td>
	<td>
		    {{ sensor.location }}
	</td>
	<td>
		<input type="button" value="RAW Data" class="btn btn-small btn-warning" v-on:click="showRaw(sensor.id)">

		<router-link :to="{ name: 'edit', params: { id: sensor.id }}">
		<input type="button" value="Edit" class="btn btn-small btn-success">
		</router-link>
		
		<input type="button" value="Delete" class="btn btn-small btn-danger">
	</td>
	</tr>
</tbody>
</table>
</div>
</div>
    </template>

    <script>
	 export default {
        mounted() {
            console.log('Component mounted.')
	     this.getSensors();
        },
        data() {
            return {
              sensors: "",
              rawData: ""
            };
        },
        methods: {
	    showRaw(id){
                let currentObj = this;

                axios.get('/api/sensors/'+id+'/data', {      })
                .then(function (response) {
                    currentObj.rawData = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
	    },
            getSensors() {
                let currentObj = this;
                axios.get('/api/sensors/', {      })
                .then(function (response) {
                    currentObj.sensors = response.data;
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
