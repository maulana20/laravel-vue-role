import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import auth from './middleware/auth'
import router from './router'
import { HasError, AlertError, AlertSuccess } from 'vform'

window.Vue = Vue;

Vue.router = router
Vue.use(VueRouter);

Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAuth, auth)

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('modal', require('./components/ModalComponent.vue').default);
Vue.component('validation-errors', require('./components/ValidationErrorsComponent.vue').default);
Vue.component('index', require('./components/IndexComponent.vue').default);
Vue.component('navigation', require('./components/NavigationComponent.vue').default);
[ HasError, AlertError, AlertSuccess ].forEach(Component => {
	Vue.component(Component.name, Component)
})

const app = new Vue({
  el: '#app',
  router
});
