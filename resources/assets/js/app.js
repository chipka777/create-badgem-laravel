
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


require('./components/Navigation');
require('./components/Main-page');
require('./components/Categories');
require('./components/Images');
require('./components/Images-show');
require('./components/Images-favorite');
require('./components/Images-create');
require('./components/Admin-users');
require('./components/Notification');
require('./components/History');



import ElementUI from 'element-ui'

//Vue.component('categories', require('./components/Categories.js'));
Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
Vue.http.interceptors.push((request, next) => {
    request.credentials = true;
    next();
});

Vue.use(ElementUI);

const app = new Vue({
    components: {
      },
    el: '#app',
    data: {
    },
    beforeMount: function() {
    },
    methods: {
    }
});
