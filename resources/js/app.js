/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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

//listing
Vue.component('listings-component', require('./components/listing/Listings.vue').default);
Vue.component('createlisting-component', require('./components/listing/CreateListing.vue').default);

//event
Vue.component('events-component', require('./components/event/Events.vue').default);
Vue.component('createevent-component', require('./components/event/CreateEvent.vue').default);

//searchbar
Vue.component('searchbar', require('./components/UIhelpers/SearchBar.vue').default);

//admin
Vue.component('admin', require('./components/admin/Admin.vue').default);
Vue.component('manageusers', require('./components/admin/ManageUsers.vue').default);
Vue.component('bulletin', require('./components/admin/Bulletin.vue').default);

//home
Vue.component('home-component', require('./components/Home.vue').default);



import Vue from 'vue'
import helper from './helper';
import DateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import TextareaAutosize from 'vue-textarea-autosize'


Vue.component('DateTimePicker', DateTimePicker);

const plugin = {
    install () {
      Vue.helper = helper
      Vue.prototype.$helper = helper
    }
  }

  Vue.use(plugin);
  Vue.use(TextareaAutosize);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#main',

});
