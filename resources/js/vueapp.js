require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import App from './components/App'
import Welcome from './components/Welcome'
import ListSensor from './components/sensor/ListSensor'
import EditSensor from './components/sensor/EditSensor'

import ListDashboard from './components/dashboard/ListDashboard'
import EditDashboard from './components/dashboard/EditDashboard'
import AttachSensor from './components/dashboard/AttachSensor'

Vue.use(BootstrapVue);
Vue.use(VueRouter)


    const router = new VueRouter({
        mode: 'history',
        routes: [
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
                path: '/dashboard/edit/:id/add/sensor',
                name: 'AttachSensor',
                component: AttachSensor
            },              
        ],
    })
    
    const app = new Vue({
        el: '#app',
        components: { App },
        router,
    });
