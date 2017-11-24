Vue.component('images-create', {
    data: function () {
        return {
            categories: [],
            preImages: [],
            uploadImages: [],
            error: '',
            success: '',
            wd: 0,
            current: 0,
            zoomImage: '',
        }
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories: function() {
            this.$http.get('/api/v1/categories/all').then(response => {
                this.categories = response.data;
            }, response => {
                console.log('Some error with categories api!');
            });
        },
        setPreloadImages: function(event) {
            this.preImages = event.target.files;
            this.setImageNames();
            this.error = '';
            this.success = '';
           // this.uploadImages.reverse();
        },
        setUpload: function(index = 0) {
            if (this.preImages.length == 0) {
                this.error = "Please select Images";
                return false;
            }
            this.error = '';
            this.success = '';
            $('#upload-progress').show();
            if (index >= this.preImages.length) {
                this.preImages = [];
                $('.image-preview input[type="text"]').val(" ");
                setTimeout(this.hideProgressBar, 500);
                this.success = "Images successfully uploaded";
                return false;
            }

            var data = new FormData();
      
            data.append("image", this.preImages[index]);
            
            var self = this;
            var cat_id = $('.image-category').val();

            this.$http.post('/dashboard/images/' + cat_id, data, {
                progress(e) {
                    if (e.lengthComputable) {
                        var percent = (e.loaded / e.total) * 100;
                        self.setBeforeProgressBar(percent, index);
                    }
                }
            }).then(response => {
                $('.upload-drop-zone').show();
                var image = response.body;

                if (!this.uploadImages[this.current]) this.uploadImages.push([]);
                
                var ln_a = this.uploadImages[this.current].length;

                if (ln_a == 4) {
                    this.uploadImages.push([]);
                    this.current++;
                }

                this.uploadImages[this.current].push(image); 
                ++index;
                this.setUpload(index);
                
            }, response => {
                this.error = response.body;
                setTimeout(this.hideProgressBar, 500);
            });
            

        },
        openZoomModal: function(name) {
            $('#enlargeImageModal').modal('show');
            this.zoomImage = name;
        },  
        deleteImage: function(id) {
            this.$http.delete('/dashboard/images/' + id).then(response => {
                var images = [];
                var tmp = [];
                var data = [];
                var counter = 0;
                
                for(var key in this.uploadImages) {
                    for (var img_key in this.uploadImages[key]) {
                        if (this.uploadImages[key][img_key].id != id) images.push(this.uploadImages[key][img_key]);
                    }
                }
                
                var ln = images.length;

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
                this.uploadImages = data;
            }, response => {
               console.log('Error');
            });
        },
        setProgressBar: function(index) {
            this.wd = ((index + 1)/ this.preImages.length) * 100;
            $('#upload-progress>.progress-bar').attr('style', 'width: ' + this.wd + '%');
        },

        setBeforeProgressBar: function(percent, index) {
            var wd =  (index/ this.preImages.length) * 100;

            wd += ((percent/100) * (1/ this.preImages.length)) * 100; 
            $('#upload-progress>.progress-bar').attr('style', 'width: ' + wd + '%');
        },
        hideProgressBar: function() {
            $('#upload-progress').hide();
           
            $('#upload-progress>.progress-bar').attr('style', 'width: 0%');
        },
        
        setImageNames: function() {
            var ln = this.preImages.length;
             $('.image-preview input[type="text"]').val(" ");
            for (var key = 0; key < ln; key++) {
                var val = $('.image-preview input[type="text"]').val(); 

                $('.image-preview input[type="text"]').val( val + " " + this.preImages[key].name + ", ");

                if (key == ln-1) $('.image-preview input[type="text"]').val( val + " " + this.preImages[key].name);
            }
        }
    }
}) 