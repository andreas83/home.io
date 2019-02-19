    <template>
      <div class="wrapper">

                <nav id="sidebar" >

                    <ul class="list-unstyled components">
                        <router-link :to="{ name: 'ShowDashboard' }" class="nav-link">Home</router-link>
                        <router-link :to="{ name: 'ListDashboard' }" class="nav-link" >Dashboard Configuration</router-link>
                        <router-link :to="{ name: 'ListSensor' }" class="nav-link" >Sensor Configuration</router-link>

                    </ul>

            </nav>

            <div id="content">

                <main>
                  <router-view></router-view>
              </main>
           </div>
        </div>
    </template>
    <script>
        export default {}
    </script>
    <style>
    .wrapper {
        display: flex;
        width: 100%;
    }
    #content{ margin-left: 300px; width: 80%; }
    #sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 999;
        background: #32383e;
        color: #fff;
        transition: all 0.3s;
    }
    </style>
