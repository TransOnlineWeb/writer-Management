/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { Form, HasError, AlertError } from 'vform';

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

window.Form = Form;

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})
let routes = [
    { path: '/foo', component: require('./components/ExampleComponent.vue').default },
    { path: '/order', component: require('./components/AdminOrders.vue').default },
    { path: '/writer', component: require('./components/Writers.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/profile', component: require('./components/profile.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/chat', component: require('./components/Chat.vue').default },
];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

//sweetalert
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
window.Fire =  new Vue();

import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
window.PulseLoader = PulseLoader;


// Numeric input
import VueNumericInput from 'vue-numeric-input';
Vue.use(VueNumericInput);

// Datetime
import { Datetime } from 'vue-datetime';
Vue.component('datetime', Datetime);

// Checkbox
import CheckboxRadio from 'vue-checkbox-radio';
Vue.use(CheckboxRadio);

//ToggleButton
import ToggleButton from 'vue-js-toggle-button';
Vue.use(ToggleButton);
//filter for Uppercase
Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});
//filter for date
Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
