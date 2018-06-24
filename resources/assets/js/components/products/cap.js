import Paginate from 'vuejs-paginate'

Vue.component('product-cap', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            createModal: false,
            editModal: false,  
            deleteModal: false,         
            create: {
                type: 'cap'
            },
            edit: {},
            offset: 0,
            loading: false,
            pageCount: 0,
            perPage: 20,
            currentPage: 0,
            products: [],
            delete: 0,
            errorMessage: '',
        }
    },
    mounted: function() {
        this.getItems();
    },
    methods: {
        getItems: function() {
            this.loading = true;

            this.$http.get('cap/get/' + this.perPage + '/' + this.offset).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.products = response.body.products.map(function (item) {
                    if (item.extra_images) {
                        item.extra = item.extra_images.split('|');
                    }

                    return item;
                });

            
                this.loading = false;
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
        },

        addItem: function() {
            $('#errorBox').hide();
            this.loading = true;
            var data = new FormData();
      
            $.each($('#extraImages')[0].files, function (index, item) {
                data.append("extra_images[]", item);                
            });
            data.append("photo", $('#mainImage')[0].files[0]);
            data.append("name", this.create.name);
            data.append("price", this.create.price);
            data.append("story", this.create.story);
            data.append("sizes", this.create.sizes);
            data.append("type", this.create.type);            

            this.$http.post('cap/create', data).then(response => {
                this.loading = false;
                this.createModal = false;

                this.getItems();
            }, response => {
                this.loading = false;
                
                if (response.status === 422) {
                    this.errorMessage = response.body.message;
                    $('#errorBox').removeClass('hidden').show();
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'An error has occurred. Try later.',
                        duration: 10000,
                    });
                }            
            });
        },

        editItem: function() {
            $('#errorBox').hide();
            this.loading = true;
            var data = new FormData();
      
            if ( $('#editMainImage')[0].files[0] !== undefined) {
                data.append("photo", $('#editMainImage')[0].files[0]);
            } else {
                data.append("photo", this.edit.photo);                
            }
             if ( $('#editExtraImages')[0].files[0] !== undefined) {
                $.each($('#editExtraImages')[0].files, function (index, item) {
                    data.append("extra_images[]", item);                
                });
            }
            data.append("extra_exist_images", this.edit.extra_images);
            data.append("name", this.edit.name);
            data.append("price", this.edit.price);
            data.append("story", this.edit.story);
            data.append("sizes", this.edit.sizes);
            data.append("id", this.edit.id);            
            data.append("type", this.edit.type);                        

            this.$http.post('cap/edit', data).then(response => {
                this.loading = false;
                this.editModal = false;

                this.getItems();
            }, response => {
                this.loading = false;
                
                if (response.status === 422) {
                    this.errorMessage = response.body.message;
                    $('#errorBox').removeClass('hidden').show();
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'An error has occurred. Try later.',
                        duration: 10000,
                    });
                }            
            });
        },

        removeExtra: function (key) {
            let data = {
                id: this.edit.id,
                image: this.edit.extra[key]
            };
            this.loading = true;

            this.$http.post('cap/delete-extra', data).then(response => {
                this.loading = false;

                this.edit.extra = response.body.extra.split('|');
                this.edit.extra_images = response.body.extra;                

                this.products[this.edit.productKey].extra = response.body.extra.split('|');
                this.products[this.edit.productKey].extra_images = response.body.extra;
                
            }, response => {
                this.loading = false;
                
                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });           
            });
        },

        paginateCallBack: function(pageNum) {
            this.offset = (pageNum * this.perPage) - this.perPage;
            this.currentPage = pageNum;
            this.getItems();
        },

        editProductOpen: function(key) {
            this.editModal = true;
            this.edit = this.products[key];
            this.edit.productKey = key;
            if (this.edit.type == 'product') {
                this.edit.type = 'cap';
            }
            $('#editMainImage').val('');
        },

        deleteProductOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.products[key].id;
        },

        deleteProduct: function() {
            this.loading = true;
            
            this.$http.delete('cap/delete/' + this.delete).then(response => {
                this.loading = false;
                this.deleteModal = false;  

                this.getItems();
                
            }, response => {
                this.loading = false;
                this.deleteModal = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
                
        },
    }
}) 