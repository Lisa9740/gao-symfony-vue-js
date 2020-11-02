import Vue from 'vue';
import Example from './js/Components/home.vue'
import Vuetify from "vuetify";
/**
 * Create a fresh Vue Application instance
 */
Vue.use(Vuetify);

new Vue({
    el: '#app',
    components: {Example},
    vuetify : new Vuetify(),
    template: "<example/>"
});
