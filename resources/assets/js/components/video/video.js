import Paginate from 'vuejs-paginate'

Vue.component('youtube-video', {
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
            videos: [],
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

            this.$http.get('videos/get/' + this.perPage + '/' + this.offset).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.videos = response.body.videos;
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

        addVideo: function() {
            $('#errorBox').hide();
            this.loading = true;
            var data = new FormData();
    
            if (this.thumbnailByApi) {
                data.append("thumbnail", 'api');
            } else {
                data.append("thumbnail", $('#thumbnail')[0].files[0]);
            }
            data.append("name", this.create.name);
            data.append("video_id", this.create.video_id);           

            this.$http.post('videos', data).then(response => {
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
    
            data.append("_method" , 'PUT');          
                       
            if (this.thumbnailByApi) {
                data.append("thumbnail", 'api');
            }
            if ($('#editThumbnail')[0].files[0] !== undefined && !this.thumbnailByApi) {
                data.append("thumbnail", $('#editThumbnail')[0].files[0]);
            } 
            if ($('#editThumbnail')[0].files[0] == undefined && !this.thumbnailByApi) {
                data.append("thumbnail", this.edit.thumbnail); 
            }
            data.append("name", this.edit.name);
            data.append("video_id", this.edit.video_id); 

            this.$http.post('videos/' + this.edit.id, data).then(response => {
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

        editVideoOpen: function(key) {
            this.editModal = true;
            this.edit = this.videos[key];
            this.edit.productKey = key;
            this.thumbnailByApi = false;
            this.changeThumbnailCheckbox();
            $('#editThumbnail').val('');
        },

        deleteVideoOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.videos[key].id;
        },

        deleteVideo: function() {
            this.loading = true;
            
            this.$http.delete('videos/' + this.delete).then(response => {
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

        changeThumbnailCheckbox: function() {
            if (this.thumbnailByApi ) {
                $('#thumbnail').attr('disabled', 'disabled');
                $('#editThumbnail').attr('disabled', 'disabled');                
            } else {
                $('#thumbnail').removeAttr('disabled', '');
                $('#editThumbnail').removeAttr('disabled', '');
            }

        }
    }
}) 