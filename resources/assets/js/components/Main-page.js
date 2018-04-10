Vue.component('main-page', {
    data: function () {
        return {
            images: [],
            bulletins: [],
            offset: 0,
            flag: 0,
            flagMany: 0,            
            spiral: 0,
            insta: 0,
            itemsTmp: 0,
            stop: 0,
            loading: false,
            updateDate: Date.now(),
            currentSection: 'images',
            currentType: 'images',            
        }
    },
    beforeUpdate: function() {
        var differenceTime = Date.now() - this.updateDate;

        if (differenceTime > 60000) {
            this.updateDate = Date.now();            
            this.$parent.$options.methods.setActivity();
        }
    },
    mounted: function() {
        this.getImages();
    },
    methods: {
        getImages: function(cat_id = 'all', count = 70, cat = false) {           
            if (cat_id == '0') cat_id = 'all';
            this.loading = true;
            
            this.hideToolTip();

            this.$http.get('/api/v1/images/' + cat_id + '/' + count + '/0').then(response => {
                this.currentSection = 'images';
                this.currentType = 'images';

                this.images = response.data;
                this.offset = 50;
                this.loading = false;
                
            }, response => {
                this.loading = false;                
                console.log('Some error with images api!');
            });
        },

        /*getInstaImages: function () {
            this.hideNav();
            
            this.$http.post('/api/v1/images/instagram').then(response => {
                this.insta = 1;
                this.images = response.data;
                this.offset = 20;
                this.showNav();
                this.hideToolTip();
            }, response => {
                console.log('Some error with instagram images api!');
            });
        },*/

        setImageToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.stop) return false;

            this.flag = 1;
            this.hideToolTip();
            
            this.$http.get('/api/v1/images/' + cat_id + '/20/' + this.offset).then(response => {
                this.offset += 20;
                if (response.data.length < 1) this.stop = 1;

                images = response.data;                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = 0;
                this.spiralRight();
            }, response => {
                console.log('Some error with images api!');
            });
        },

        homeLoad: function() {
            this.getImages();
            console.log('homeLoad');
        },

        bulletinLoad: function() {
            this.loading = true;
            this.hideToolTip();            
            
            this.$http.get('/api/v1/bulletin').then(response => {
                if (response.body.status === "OK") {
                    this.bulletins = response.body.bulletins;

                    this.currentSection = 'bulletins';
                    this.currentType = 'bulletins';                    
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with bulletins api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with bulletins api',
                    duration: 10000,
                });
             });
        },

        creationsLoad: function(count = 50) {
            this.loading = true;
            this.hideToolTip();            

            if (this.currentType != 'creations') {
                this.offset = 0;
            }

            this.$http.get('/api/v1/creations/' + count + '/' + this.offset).then(response => {
                if (response.body.status === "OK") {
                    this.images = response.body.images;

                    this.currentSection = 'images';
                    this.currentType = 'creations';
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with creations api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with creations api',
                    duration: 10000,
                });
             });
        },

        favoritesLoad: function(count = 50) {
            this.loading = true;
            this.hideToolTip();

            if (this.currentType != 'favorites') {
                this.offset = 0;
            }

            this.$http.get('/api/v1/favorites/' + count + '/' + this.offset).then(response => {
                if (response.body.status === "OK") {
                    this.images = response.body.images;

                    this.currentSection = 'images';
                    this.currentType = 'favorites';
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with favorites api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with favorites api',
                    duration: 10000,
                });
             });
        },

        historiesLoad: function(count = 50) {
            this.loading = true;
            this.hideToolTip();

            if (this.currentType != 'histories') {
                this.offset = 0;
            }

            this.$http.get('/api/v1/histories/' + count + '/' + this.offset).then(response => {
                if (response.body.status === "OK") {
                    this.images = response.body.images;

                    this.currentSection = 'images';
                    this.currentType = 'histories';
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with favorites api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with favorites api',
                    duration: 10000,
                });
             });
        },

        spiralRight: function() {
            last = Number($('.panels div:last-child').attr('data-pos')) - 1;
            self = this;
            cat_id = $('#select-cat').val();
            if (cat_id == '0') cat_id = 'all';

            if (last < 9 && !this.flag) this.setImageToPanels(last + 1, cat_id);
            if (this.flag) return false;

            if (last > 0) {
                ln = this.images.length;
                images = this.images;
                for(var i = 0; i < ln; i++) {
                    images[i].num -= 1;
                }
                this.images = images;

                this.flag = 0;
            }
        },

        spiralLeft: function() {
            first = Number($('.panels div:first-child').attr('data-pos'));
            if (first < 1) {
                ln = this.images.length;
                images = this.images;
                for(var i = 0; i < ln; i++) {
                    images[i].num += 1;
                }
                
                this.images = images;
            }
        },
        spiralManyLeft: function() {
            if (this.flagMany) return false;
            this.flagMany = 1;
            var self = this;
            self.itemsTmp = 0;
            var timer = setInterval(function() {
                    self.spiralLeft();
                    self.itemsTmp += 1;
                    first = Number($('.panels div:first-child').attr('data-pos'));
                    if (self.itemsTmp > 9 || first >= 1) {
                        clearInterval(timer);
                        self.itemsTmp = 0;
                        self.flagMany = 0;
                    }
                }, 150);
    
        },

        spiralManyRight: function() {
           
            if (this.flagMany) return false;
            this.flagMany = 1;
            var self = this;
            self.itemsTmp = 0;
            var timer = setInterval(function() {
                    setTimeout(self.spiralRight, 0 );
                    self.itemsTmp += 1;
                    if (self.flag) self.itemsTmp -= 1;
                    if (self.itemsTmp > 9) {
                        clearInterval(timer);
                        self.itemsTmp = 0;
                        self.flagMany = 0;
                    }
                }, 150);
    
        },

        savePNG: function() {
            html = '';
            images = [];
            $('.canvas-mask').fadeIn('slow');
            $('.canvas-loader').fadeIn('slow');
            $('.canvas>.canva-img').each(function (num,item) {
                val = $(this).children('img').attr('src');
                src = "upload/" + val.substring(val.lastIndexOf('/')+1,val.length);
                image = {
                    'height': ((Math.round($(this).height() / $(this).parent().height() * 100) * 768)/100),
                    'width': ((Math.round($(this).width() / $(this).parent().width() * 100) * 1152)/100),
                    'rotate': getRotationDegrees($(this)),
                    'src': src, 
                    'top': ((Math.round(Number($(this).css('top').slice(0, -2)) / $(this).parent().height() * 100) * 768)/100),
                    'left': ((Math.round(Number($(this).css('left').slice(0, -2)) / $(this).parent().width()  * 100) * 1152)/100)
                };
                
                images[num] = image;

            });
            
            this.$http.post('/api/v1/images/create', {'images': images}).then(response => {
                a = window.location.replace("http://create.badge-m.com/download");
                $('.canvas-mask').fadeOut('slow');
                $('.canvas-loader').fadeOut('slow');
            }, response => {
                console.log('Some error with images api!');
            });
        },

        showToolTip: function(event, index) {
            if (window.main_flag) return false;

            console.log(event.target);

            var img = this.images[index];

            var style = "top:" + (event.pageY + 10) + 'px;left:' + (event.pageX + 10) + 'px;';

            var date = new Date(img.created_at);

            date = date.getDate() + '-' + date.getMonth() + '-' + date.getFullYear();
            
            $('body').prepend('<div id="tooltip" style="'+style+'">Created: '+ date +' <br/> Author: '+img.user+' <br/> Favorited : '+img.favorited+'</div>');

            $('html').on('mousemove', function(event) {
                $('#tooltip').css({'top': event.pageY + 10, 'left': event.pageX + 10});
            });
        },

        hideToolTip: function(event, index) {
            if (window.main_flag) return false;
            $('html').off('mousemove');

            $('#tooltip').remove();
        },

     }
}) 