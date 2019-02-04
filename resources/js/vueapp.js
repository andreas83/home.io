require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
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




Vue.use(BootstrapVue);
Vue.use(VueRouter);



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
                path: '/dashboard/:dashboard_id/configure/sensor/:sensor_id',
                name: 'ConfigureSensor',
                component: ConfigureSensor
            },              
        ],
    })
    
    const app = new Vue({
        el: '#app',
        components: { App },
        router,
    });