require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App'
import Welcome from './components/Welcome'
import ListSensor from './components/ListSensor'
import EditSensor from './components/EditSensor'


Vue.use(VueRouter)


    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/home',
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
        ],
    })
    const app = new Vue({
        el: '#app',
        components: { App },
        router,
    });
