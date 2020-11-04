import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './js/views/home.vue';


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [{
        path: '/',
        name: 'home',
        component: Home,
    },

    ]
})


export default router;
