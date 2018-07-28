import Paginate from 'vuejs-paginate'

Vue.component('admin-bulletin', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            createModal: false,
            editModal: false,  
            deleteModal: false,    
            thumbnailByApi: false,                 
            create: {},
            edit: {},
            offset: 0,
            loading: false,
            pageCount: 0,
            perPage: 20,
            currentPage: 0,
            bulletins: [],
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

            this.$http.get('bulletin/get/' + this.perPage + '/' + this.offset).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.bulletins = response.body.bulletins;
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

        addBulletin: function() {
            $('#errorBox').hide();
            this.loading = true;
            var data = new FormData();

            data.append("name", this.create.name);
            data.append("description", this.create.description);           

            this.$http.post('bulletin', data).then(response => {
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

        editBulletin: function() {
            $('#errorBox').hide();
            this.loading = true;
            var data = new FormData();
    
            data.append("_method" , 'PUT');          
                       
            data.append("name", this.edit.name);
            data.append("description", this.edit.description);    

            this.$http.post('bulletin/' + this.edit.id, data).then(response => {
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

        paginateCallBack: function(pageNum) {
            this.offset = (pageNum * this.perPage) - this.perPage;
            this.currentPage = pageNum;
            this.getItems();
        },

        editBulletinOpen: function(key) {
            this.editModal = true;
            this.edit = this.bulletins[key];
        },

        deleteBulletinOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.bulletins[key].id;
        },

        deleteBulletin: function() {
            this.loading = true;
            
            this.$http.delete('bulletin/' + this.delete).then(response => {
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