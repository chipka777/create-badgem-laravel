
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


Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data: {
        categories: [],
        images: [],
        offset: 0,
        flag: 0,
        spiral: 0,
    },
    beforeMount: function() {
        this.getCategories();
        this.getImages();
    },
    methods: {
        getCategories: function() {
            this.$http.get('/api/v1/categories').then(response => {
                this.categories = response.data;
            }, response => {
                alert('Some error with categories api!');
            });
        },

        getImages: function(cat_id = 'all', count = 20) {
            if (cat_id == '0') cat_id = 'all';
            this.$http.get('/api/v1/images/' + cat_id + '/' + count + '/0').then(response => {
                this.images = response.data;
                this.offset = 20;
            }, response => {
                alert('Some error with images api!');
            });
        },

        setImageToPanels: function(last, cat_id = 'all') {
            if (this.flag) return false;
            this.flag = 1;
            this.$http.get('/api/v1/images/' + cat_id + '/10/' + this.offset).then(response => {
                this.offset += 10;
                images = response.data;
                for (var i = 0; i < images.length; i++) {
                    $('.panels').append('<div id="img-'+images[i].id+'" data-pos="'+(last+i+1)+'" class="panel canva-img test pos'+(last+i+1)+'"><img onmousedown="panelImg(event, $(this))" src="upload/'+images[i].name+'"></div>');
                }
                this.flag = 0;
            }, response => {
                alert('Some error with images api!');
            });
        },

        spiralRight: function() {
            last = Number($('.panels div:last-child').attr('data-pos')) - 1;
            self = this;
            cat_id = $('#select-cat').val();
            if (cat_id == '0') cat_id = 'all';
            if (last < 19 && !this.flag) this.setImageToPanels(last + 1, cat_id);
            if (this.flag) return false;
            $('.panels').children().each(function() {
                pos = Number($(this).attr('data-pos'));
                $(this).attr('data-pos', pos-1).removeClass('pos'+pos).addClass('pos'+ (pos-1));
                this.flag = 1;
            });
            this.flag = 0;
        },

        spiralLeft: function() {
            first = Number($('.panels div:first-child').attr('data-pos'));
            if (first < 1) {
                $('.panels').children().each(function() {
                    pos = Number($(this).attr('data-pos'));

                    $(this).attr('data-pos', pos+1).removeClass('pos'+pos).addClass('pos'+ (pos+1));
                });
            }
        },

 
    }
});
