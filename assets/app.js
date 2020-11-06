import Vue from 'vue';
import Example from './js/views/Home.vue'
import Routes from './route.js'
import Layout from './js/layout/layout.vue';
import Vuetify from "vuetify";
/**
 * Create a fresh Vue Application instance
 */
Vue.use(Vuetify);

new Vue({
    el: '#app',
    vuetify : new Vuetify(),
    router: Routes,
    components: { Layout },

});
