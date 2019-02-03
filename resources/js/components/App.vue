    <template>
        <div class="container-fluid">
                <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <ul class="navbar-nav">
                        <router-link :to="{ name: 'ShowDashboard' }" class="nav-link">Home</router-link>
                        <router-link :to="{ name: 'ListDashboard' }" class="nav-link" >Dashboard Configuration</router-link>
                        <router-link :to="{ name: 'ListSensor' }" class="nav-link" >Sensor Configuration</router-link>
                        
                    </ul>
                </div>
            </nav>
            <main>
                <router-view></router-view>
            </main>
        </div>
    </template>
    <script>
        export default {}
    </script>
