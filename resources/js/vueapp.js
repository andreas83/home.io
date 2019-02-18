require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import Vuex from 'vuex'

import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import App from './components/App'

import Welcome from './components/Welcome'
import ListSensor from './components/sensor/ListSensor'
import EditSensor from './components/sensor/EditSensor'
import ShowDashboard from './components/dashboard/ShowDashboard'
import ListDashboard from './components/dashboard/ListDashboard'
import EditDashboard from './components/dashboard/EditDashboard'
import ConfigureSensor from './components/dashboard/ConfigureSensor'
import axios from 'axios';


Vue.use(Vuex);
Vue.use(BootstrapVue);
Vue.use(VueRouter);

Vue.component('sensor-datatable', require('./components/sensorData/Table').default);
Vue.component('LineChart', require('./components/charts/Line').default);
Vue.component('BarChart', require('./components/charts/Bar').default);

    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'ShowDashboard',
                component: ShowDashboard,
            },
            {
                path: 'home',
                name: 'welcome',
                component: Welcome,
            },

            {
                path: '/list/sensor',
                name: 'ListSensor',
                component: ListSensor
            },
            {
                path: '/sensor/edit/:id',
                name: 'EditSensor',
                component: EditSensor
            },
            {
                path: '/list/dashboard',
                name: 'ListDashboard',
                component: ListDashboard
            },
            {
                path: '/dashboard/edit/:id',
                name: 'EditDashboard',
                component: EditDashboard
            },
            {
                path: '/dashboard/:dashboard_id/configure/item/:item_id',
                name: 'ConfigureSensor',
                component: ConfigureSensor
            },
        ],
    })

    import { Store } from 'vuex';
    import { mapResourceModules } from '@reststate/vuex';
    const api = axios.create({
      baseURL: 'http://localhost:3000/api/v1/',
      headers: {
        'Content-Type': 'application/vnd.api+json',

      },
    });

    const store = new Store({
        modules: {
            ...mapResourceModules({
            names: [
              'sensors',
              'dashboards',
              'sensorDatas',
              'dashboardItems',
            ],
            httpClient: api,
          }),
        },
      });


    const app = new Vue({
        el: '#app',
        components: { App },
        store: store,
        router,
    });
