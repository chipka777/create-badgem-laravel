Vue.component('main-page', {
    data: function () {
        return {
            images: [],
            bulletins: [],
            offset: 0,
            flag: false,
            flagMany: 0,            
            spiral: 0,
            insta: 0,
            itemsTmp: 0,
            stop: 0,
            loading: false,
            updateDate: Date.now(),
            currentSection: 'images',
            currentType: 'images',      
            lastHovered: '',     
            loadFavorited: false,
            sections: {
                images: {
                    stop: false,
                    offset: 0,
                },
                creations: {
                    stop: false,
                    offset: 0,
                },
                favorites: {
                    stop: false,
                    offset: 0,
                },
                bulletins: {
                    stop: false,
                    offset: 0,
                },
                histories: {
                    stop: false,
                    offset: 0,                    
                }
            }
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
            this.sections.images.offset = 0;

            this.hideToolTip();

            this.$http.get('/api/v1/images/' + cat_id + '/' + count + '/0').then(response => {
                this.currentSection = 'images';
                this.currentType = 'images';

                this.images = response.data;
                this.sections.images.offset = count;
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
            if (this.flag || this.sections.images.stop) return false;

            this.flag = true;
            this.hideToolTip();
            
            this.$http.get('/api/v1/images/' + cat_id + '/20/' + this.sections.images.offset).then(response => {
                this.sections.images.offset += 20;

                images = response.data;                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = false;

                if (response.data.length < 1){
                    this.sections.images.stop = true;
                } else {
                    this.spiralRight();
                }

            }, response => {
                console.log('Some error with images api!');
            });
        },

        setCreationsToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections.creations.stop) return false;

            this.flag = true;
            this.hideToolTip();

            this.$http.get('/api/v1/creations/20/' + this.sections.creations.offset).then(response => {
                this.sections.creations.offset += 20;

                images = response.data.images;                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = false;                

                if (response.data.count == 0){
                    this.sections.creations.stop = true;
                } else {
                    this.spiralRight();
                }
                
            }, response => {
                console.log('Some error with images api!');
            });
        },

        setFavoritesToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections.favorites.stop) return false;

            this.flag = true;
            
            this.hideToolTip();

            this.$http.get('/api/v1/favorites/20/' + this.sections.favorites.offset).then(response => {
                this.sections.favorites.offset += 20;

                images = response.data.images;                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = false;                

                if (response.data.count == 0){
                    this.sections.favorites.stop = true;
                } else {
                    this.spiralRight();
                }
                
            }, response => {
                console.log('Some error with images api!');
            });
        },

        setBulletinsToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections.bulletins.stop) return false;

            this.flag = true;
            
            this.hideToolTip();

            this.$http.get('/api/v1/bulletin/20/' + this.sections.bulletins.offset).then(response => {
                this.sections.bulletins.offset += 20;

                bulletins = response.data.bulletins;                
                last_num = this.bulletins[this.bulletins.length - 1].num;

                ln = bulletins.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    bulletins[i].num = last_num;
                }
                bulletins = this.bulletins.concat(bulletins);

                this.bulletins = bulletins;

                this.flag = false;                

                if (response.data.count == 0){
                    this.sections.bulletins.stop = true;
                } else {
                    this.spiralRight();
                }
                
            }, response => {
                console.log('Some error with images api!');
            });
        },

        setHistoriesToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections.histories.stop) return false;

            this.flag = true;
            
            this.hideToolTip();

            this.$http.get('/api/v1/histories/20/' + this.sections.histories.offset).then(response => {
                this.sections.histories.offset += 20;

                images = response.data.images;                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = false;                

                if (response.data.count == 0){
                    this.sections.histories.stop = true;
                } else {
                    this.spiralRight();
                }
                
            }, response => {
                console.log('Some error with images api!');
            });
        },

        homeLoad: function() {
            this.getImages();
        },

        bulletinLoad: function(count = 50) {
            this.loading = true;
            this.hideToolTip();            
            
            this.sections.bulletins.offset = 0;

            this.$http.get('/api/v1/bulletin/' + count + '/' + this.sections.bulletins.offset).then(response => {
                this.sections.bulletins.offset = count;
            
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
            
            this.sections.creations.offset = 0;

            this.$http.get('/api/v1/creations/' + count + '/' + this.sections.creations.offset).then(response => {
                this.sections.creations.offset = count;

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

            this.sections.favorites.offset = 0;

            this.$http.get('/api/v1/favorites/' + count + '/' + this.sections.favorites.offset).then(response => {
                this.sections.favorites.offset = count;
                
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

            this.sections.histories.offset = 0;

            this.$http.get('/api/v1/histories/' + count + '/' + this.sections.histories.offset).then(response => {
                this.sections.histories.offset = count;

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
            last = Number($('.panels div:last').attr('data-pos')) - 1;
            self = this;
            cat_id = $('#select-cat').val();
            if (cat_id == '0') cat_id = 'all';

            if (this.flag) return false;
            
            if (last < 9 && !this.flag) {
                switch (this.currentType) {
                    case 'images':
                        this.setImageToPanels(last + 1, cat_id);
                        break;
                    case 'creations':
                        this.setCreationsToPanels(last + 1, cat_id);
                        break;
                    case 'favorites':
                        this.setFavoritesToPanels(last + 1, cat_id);
                        break;
                    case 'bulletins':
                        this.setBulletinsToPanels(last + 1, cat_id);
                        break;
                    case 'histories':
                        this.setHistoriesToPanels(last + 1, cat_id);
                        break;
                }
            } 

            if (last > 0) {
                if (this.currentSection == 'images') {
                    ln = this.images.length;
                    images = this.images;
                    for(var i = 0; i < ln; i++) {
                        images[i].num -= 1;
                    }
                    this.images = images;
                }

                if (this.currentSection == 'bulletins') {
                    ln = this.bulletins.length;
                    bulletins = this.bulletins;
                    for(var i = 0; i < ln; i++) {
                        bulletins[i].num -= 1;
                    }

                    this.bulletins = bulletins;
                    
                }
            }
        },

        spiralLeft: function() {
            first = Number($('.panels div:first-child').attr('data-pos'));
            if (first < 1) {
                if (this.currentSection == 'images') {
                    ln = this.images.length;
                    images = this.images;
                    for(var i = 0; i < ln; i++) {
                        images[i].num += 1;
                    }
                    
                    this.images = images;
                }
                if (this.currentSection == 'bulletins') {
                    ln = this.bulletins.length;
                    bulletins = this.bulletins;
                    for(var i = 0; i < ln; i++) {
                        bulletins[i].num += 1;
                    }

                    this.bulletins = bulletins;
                    
                }
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
                    setTimeout(self.spiralRight, 100 );
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

        addToFavorited: function(id,key) {            
            if (this.loadFavorited ) return false;
            if (this.images[key].favorite === true) return this.removeFromFavorited(id, key);
            
            this.loadFavorited = true;

            this.$http.get('/api/v1/images/add-to-favorite/' + id).then(response => {
                this.images[key].favorite = true;
                this.loadFavorited = false;
                

                this.$notify.success({
                    title: 'Success',
                    message: 'This badge was successfully added to favorites',
                    duration: 10000,
                });
                                 
            }, response => {
                this.loadFavorited = false;
                
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with favorites api',
                    duration: 10000,
                });
            });
        },

        removeFromFavorited: function(id,key) {
            if (this.loadFavorited ) return false;

            if (this.images[key].favorite === false) return this.addToFavorited(id, key);
            this.loadFavorited = true;

            this.$http.get('/api/v1/images/remove-from-favorite/' + id).then(response => {
                this.images[key].favorite = false;
                this.loadFavorited = false;

                this.$notify.success({
                    title: 'Success',
                    message: 'This badge was successfully removed from favorites',
                    duration: 10000,
                });
                
            }, response => {
                this.loadFavorited = false;
                
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with favorites api',
                    duration: 10000,
                });
            });
        },

        showToolTip: function(event, index) {
            if (window.main_flag) return false;

            $(event.target).children('.favorite-heart').removeClass('hidden');

            this.lastHovered = event.target;

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
            
            $(this.lastHovered).children('.favorite-heart').addClass('hidden'); 

            $('html').off('mousemove');

            $('#tooltip').remove();
        },

     }
}) 