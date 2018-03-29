
import Paginate from 'vuejs-paginate'

Vue.component('images', {
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
            cat_id: 'all',
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
            this.$http.get('/api/v1/categories/all').then(response => {
                this.categories = response.data;
            }, response => {
                console.log('Some error with categories api!');
            });
        },
        orderByCategory: function() {
            this.cat_id = $("#categoryOrder").val();
            this.offset = 0;
            this.currentPage = 0;
            this.getImages();
            this.getCountOfImages();
        },
        
        getImages: function(offset = this.offset, cat_id = this.cat_id,  count = this.perPage) {
            this.showLoader();
            this.$http.get('/api/v1/images/by-user/' + cat_id + '/' + count + '/' + offset).then(response => {
                var images = response.data;
                var ln = images.length;
                var counter = 0;
                var data = [];
                var tmp = [];
               
                for (var i = 0; i < ln; i++) {
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
            this.$http.get('/api/v1/images/count-by-user/' + cat_id).then(response => {
                this.pageCount = Math.ceil(response.body/this.perPage);
                $('.image-pagination').css('display', 'flex');
            }, response => {
                console.log('Some error with images api!');
            });
        },

        openEditModal: function(id, i, j) {
            this.showEditLoader();
            $("#product_view").modal('show');
            this.$http.get('/dashboard/images/' + id).then(response => {
                this.editImage = response.body;
                this.editImage.i = i;
                this.editImage.j = j;
                this.hideEditLoader();
            }, response => {
                console.log('Some error with images api!');
            });
            
        },

        setVisibleImage: function() {
            this.$http.get('/dashboard/images/' + this.editImage.id + '/edit').then(response => {
                this.editImage = response.body;
            }, response => {
                console.log('Some error with images api!');
            });
        },
        paginateCallBack: function(pageNum) {
            this.offset = (pageNum * this.perPage) - this.perPage;
            this.currentPage = pageNum;
            this.getImages();
        },
        openDeleteModal: function() {
            $("#product_view").modal('hide');
            $("#deleteModal").modal('show');
        },

        closeDeleteModal: function() {
            $("#product_view").modal('show');
            $("#deleteModal").modal('hide');
        },

        deleteImage: function() {
            this.showLoadBtn();
            this.$http.delete('/dashboard/images/' + this.editImage.id).then(response => {
                this.hideLoadBtn();
                
                this.getImages();
            
                $("#deleteModal").modal('hide');        
            }, response => {
               console.log('Error');
            });
        },

        showLoader: function() {
            $('.loader').show();
            $('.main-images').hide();
        },
        hideLoader: function() {
            $('.loader').hide();
            $('.main-images').show();
           
        },
        showEditLoader: function() {
            $('.edit-loader').show();
            $('.edit-modal-body').hide();
        },
        hideEditLoader: function() {
            $('.edit-loader').hide();
            $('.edit-modal-body').show();
        },
        showLoadBtn: function() {
            $('.create-btn').addClass('hidden');
            $('.create-load-btn').removeClass('hidden');
        },
        hideLoadBtn: function() {
            $('.create-btn').removeClass('hidden');
            $('.create-load-btn').addClass('hidden');
        }
    }
}) 