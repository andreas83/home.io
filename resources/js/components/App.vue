    <template>
      <div class="wrapper" v-bind:class="style">
        <div class="menu">
          <div class="app-menu">
            <ul class="list-unstyled components">
                <router-link :to="{ name: 'ShowDashboard' }" class="nav-link">Home</router-link>
                <div  v-for="dashboard in dashboards">
                <router-link :to="{ name: 'ShowDashboard' , params: { id: dashboard.id }}" class="nav-link">{{dashboard.attributes.name}}</router-link>
                <router-link :to="{ name: 'ConfigureSensor', params: { dashboard_id: dashboard.id, item_id:0 }}"  class="nav-link">
                    + Add Sensor to {{dashboard.attributes.name}}
                </router-link>
                </div>
                <router-link :to="{ name: 'ListDashboard' }" class="nav-link" >Dashboard Configuration</router-link>
                <router-link :to="{ name: 'ListSensor' }" class="nav-link" >Sensor Configuration</router-link>

            </ul>
          </div>
        </div>

        <div class="layout">
          <div class="header">
             <div class="menu-icon"><i class="fas fas-align-justify"></i></div>
            
           </div>
           <main>
             <router-view @style-change="onStyleChange"></router-view>
           </main>
         </div>
      </div>
    </template>
    <script>
        import { mapActions, mapGetters } from 'vuex';
        export default {
          data() {
            return{
                style:"clean"
            }

          },
          mounted(){

            this.loadAllDashboards();
            function toggleClassMenu() {
              myMenu.classList.add("menu--animatable");
                if(!myMenu.classList.contains("menu--visible")) {
                    myMenu.classList.add("menu--visible");
                } else {
                    myMenu.classList.remove('menu--visible');
                }
              }

              function OnTransitionEnd() {
                myMenu.classList.remove("menu--animatable");
              }

              var myMenu = document.querySelector(".menu");
              var oppMenu = document.querySelector(".menu-icon");
              myMenu.addEventListener("transitionend", OnTransitionEnd, false);
              oppMenu.addEventListener("click", toggleClassMenu, false);
              myMenu.addEventListener("click", toggleClassMenu, false);
          },
          methods: {
              ...mapActions({
                  loadAllDashboards: 'dashboards/loadAll',
              }),
              onStyleChange(val){
                  this.style=val;
                  this.$emit('style-change', val);
              }

          },
          computed: {
              ...mapGetters({
                dashboards: 'dashboards/all',
              }),
          }

        }
    </script>
    <style>

    .wrapper{
      max-width:1500px;
      margin-left: auto;
      margin-right: auto;
    }
    .menu {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 150;
    }

    .menu--visible {
        pointer-events: auto;
    }

    .app-menu {
        background-color: #fff;
        color: #fff;
        position: relative;
        max-width: 400px;
        width: 90%;
        height: 100%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
        -webkit-transform: translateX(-103%);
                transform: translateX(-103%);
        display: flex;
        flex-direction: column;
        will-change: transform;
        z-index: 160;
        pointer-events: auto;
    }

    .menu--visible .app-menu {
        -webkit-transform: none;
                transform: none;
    }

    .menu--animatable .app-menu {
        transition: all 130ms ease-in;
    }

    .menu--visible.menu--animatable  .app-menu {
        transition: all 330ms ease-out;
    }

    .menu:after {
        content: '';
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        will-change: opacity;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0,0,0.3,1);
    }

    .menu--visible.menu:after {
        opacity: 1;
        pointer-events: auto;
    }

    /* aux */

    body {
      margin: 0;
    }

    .black{
      background-color: #000;
      color:#fff;
    }

    .clean{

        background-color: #fff;

    }


    .layout {

      min-height: 667px;

      position: relative;
    }

    .header {
      background-color: #ccc;
    }

    .menu-icon {
      content: "Menu";
      color: #fff;
      background-color: #666;
      width: 40px;
      height: 40px;
    }

    .app-menu {
      width: 300px;
      height: 667px;
      box-shadow: none;
      background-color: #ddd;
    }

    .menu:after {
      width: 100%;
      height: 667px;
    }
    </style>
