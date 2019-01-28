    <template>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
			Sensor Configuration
                </div>


		<input type="button">
		  <div v-for="sensor in sensors">
		    {{ sensor.name }}
		    {{ sensor.location }}
		  </div>

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
              sensors: ""
            };
        },
        methods: {
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
        html, body {
            background-color: #fff;
            color: #939b9f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        .title {
            font-size: 60px;
        }
        .subtitle {
            font-size: 20px;
        }
        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .content {
            text-align: center;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
