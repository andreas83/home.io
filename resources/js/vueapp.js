require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App'
import Welcome from './components/Welcome'
import Configuration from './components/Configuration'
import Edit from './components/Edit'


Vue.use(VueRouter)


    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/home',
                name: 'welcome',
                component: Welcome,
                props: { title: "This is the SPA home" }
            },
            {
                path: '/configuration',
                name: 'configuration',
                component: Configuration
            },    
            {
                path: '/sensor/edit/:id',
                name: 'edit',
                component: Edit
            },    
        ],
    })
    const app = new Vue({
        el: '#app',
        components: { App },
        router,
    });
