
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('vue-resource');
require('jquery');

require('./components/Main-page');
require('./components/Categories');
require('./components/Images');
require('./components/Images-create');


//Vue.component('categories', require('./components/Categories.js'));
Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
const app = new Vue({
    el: '#app',
    data: {
    },
    beforeMount: function() {
    },
    methods: {
    }
});
