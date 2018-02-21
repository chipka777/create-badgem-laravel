
import Paginate from 'vuejs-paginate'

Vue.component('images-favorite', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            categories: [],
            images: [],
            loader: false,
            checked: 'checked',
            perPage: 12,
            pageCount: 10,
            currentPage: 0,
            cat_id: 'favorited',
            offset: 0,
            editImage: {},
        }
    },
    mounted() {
        this.getCategories();
        this.getImages();
        this.getCountOfImages();
    },
    methods: {
        getCategories: function() {
            this.$http.get('/api/v1/categories').then(response => {
                this.categories = response.data;
            }, response => {
                console.log('Some error with categories api!');
            });
        },

        getImages: function(offset = this.offset, cat_id = this.cat_id,  count = this.perPage) {
            this.showLoader();
            this.$http.get('/api/v1/images/all/' + cat_id + '/' + count + '/' + offset).then(response => {
                var images = response.data;
                var ln = images.length;
                var counter = 0;
                var data = [];
                var tmp = [];
               
                for (var i = 0; i < ln; i++) {
                    images[i].loading = false;

                    if (counter > 3 ) {
                        data.push(tmp); 
                        tmp = [];
                        counter = 0;
                    } 

                    tmp.push(images[i]);

                    if (i == (ln - 1)) {
                        data.push(tmp); 
                    }

                    counter++;
                }
                
                this.images = data;
                this.hideLoader();
            }, response => {
                console.log('Some error with images api!');
            });
        },
        getCountOfImages: function(cat_id = this.cat_id) {
            $('.image-pagination').hide();
            this.$http.get('/api/v1/images/count/' + cat_id).then(response => {
                this.pageCount = Math.floor(response.body/this.perPage);
                $('.image-pagination').css('display', 'flex');
            }, response => {
                console.log('Some error with images api!');
            });
        },

        paginateCallBack: function(pageNum) {
            this.offset = (pageNum * this.perPage) - this.perPage;
            this.currentPage = pageNum;
            this.getImages();
        },

        showLoader: function() {
            $('.loader').show();
            $('.main-images').hide();
        },
        hideLoader: function() {
            $('.loader').hide();
            $('.main-images').show();
           
        },
        addToFavorited: function(id,row,image) {
            this.images[row][image].loading = true;

            this.$http.get('/api/v1/images/add-to-favorite/' + id).then(response => {
                this.images[row][image].favorite = true;
                
                this.images[row][image].loading = false;
            }, response => {
                this.images[row][image].loading = false;

                console.log('Some error with images api!');
            });
        },

        removeFromFavorited: function(id,row,image) {
            this.images[row][image].loading = true;

            this.$http.get('/api/v1/images/remove-from-favorite/' + id).then(response => {
                this.images[row][image].favorite = false;
                
                this.images[row][image].loading = false;
            }, response => {
                this.images[row][image].loading = false;      
                console.log('Some error with images api!');
            });
        }
    }
}) 