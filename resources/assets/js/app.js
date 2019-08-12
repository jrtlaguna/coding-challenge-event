require('./bootstrap');
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'



Vue.component('layout', require('./components/home/Layout.vue'))
Vue.use(BootstrapVue)


const app = new Vue({
    el: '#app'
});


