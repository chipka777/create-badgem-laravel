Vue.component('main-page', {
    data: function () {
        return {
            images: [],
            bulletins: [],
            categories: [],
            products: [],
            currentProduct: {},
            currentProductType: 'all',
            offset: 0,
            flag: false,
            openVideoIndicator: false,
            currentUploadCategory: '',
            showAllMenu: true,
            currentVideoCode: '',
            flagMany: 0,            
            spiral: 0,
            insta: 0,
            itemsTmp: 0,
            stop: 0,
            userInvites: 0,
            zoom: 17,
            center: {lat:33.782085,lng:-117.897881},
            loading: false,
            updateDate: Date.now(),
            preImages: [],
            creationsList: [],
            avatarPreview: 'logo-phase2.png',
            currentSection: 'images',
            currentType: 'images',
            avatarView: false,
            showMenu: true,
            lastHovered: '',     
            loadFavorited: false,
            infoWinOpen: false,
            ageEdit: false,
            nameEdit: false,    
            bioEdit: false,                                
            arrowEnable: true,
            recEmail: '',
            inviteSend: false,
            currentMenuSection: 'onlycenter',
            addRoute: '',
            additionalCurrentType: '',
            cloudData: {
                text: 'Bulletin',
                title: 'Title',
                open: false,
            },
            teamCloudData: {},
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
                },
                faq: {
                    stop: false,
                    offset: 0,
                },
                instagram: {
                    stop: false,
                    max_id: 0,
                },
                team: {
                    stop: false,
                    offset: 0,
                },
                goals: {
                    stop: false,
                    offset: 0,
                },
                products: {
                    stop: false,
                    offset: 0,
                },
                videos: {
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
        this.avatarPreview = $('.avatar-src').text();
        this.getImages();
        this.getCategories();        

        this.userInvites = $('.user-invites').val();
    },
    methods: {
        getCategories: function() {
            this.$http.get('/api/v1/categories').then(response => {
                this.categories = response.data;
            }, response => {
                console.log('Some error with categories api!');
            });
        },
        getImages: function(cat_id = 'all', count = 70, menu = true, additional = '') {
            if (cat_id == '0') cat_id = 'all';
            this.loading = true;
			var self = this;
            this.sections.images.offset = 0;

            this.hideToolTip();

            this.$http.get('/api/v1/images/' + cat_id + '/' + count + '/0').then(response => {
                this.currentSection = 'images';
                this.currentType = 'images';
                this.showMenu = menu;
                this.arrowEnable = true;
                
                this.additionalCurrentType = additional;                

                this.images = response.data.map(function(item) {
					item.tmpName = item.name;
					item.name = 'logo-phase2.gif';
					
					return item;
				});
				
				setTimeout(function() {
					self.images.map(function(item) {
						item.name = item.tmpName;
						return item;
					});
				}, 500)
                this.sections.images.offset = count;
                this.loading = false;
                
            }, response => {
                this.loading = false;                
                console.log('Some error with images api!');
            });
        },

        setInstaToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections[this.currentType].stop) return false;

            this.flag = true;
            this.hideToolTip();
            
            this.$http.post('/api/v1/images/instagram', {max_id: this.sections.instagram.max_id, count: 20}).then(response => {
                this.sections.instagram.max_id = response.body.max_id;

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

                if (response.data.images.length < 1){
                    this.sections.instagram.stop = true;
                } else {
                    this.spiralRight();
                }

            }, response => {
                console.log('Some error with instagram api!');
            });
        },

        setImageToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections[this.currentType].stop) return false;

            this.flag = true;
            this.hideToolTip();
            
            this.$http.get('/api/v1/' + this.currentType + ((this.currentType == 'images') ? '/' + cat_id : '') + '/20/' + this.sections[this.currentType].offset).then(response => {
                this.sections[this.currentType].offset += 20;

                if (this.currentType == 'images') {
                    images = response.data;                
                } else {
                    images = response.data.images;                 
                }
                 this.hideToolTip();
                
                last_num = this.images[this.images.length - 1].num;

                ln = images.length;
                for (var i = 0; i < ln; i++) {
                    ++last_num;
                    images[i].num = last_num;
                }
                images = this.images.concat(images);

                this.images = images;

                this.flag = false;

                if (response.data.length < 1 || response.data.count === 0){
                    this.sections[this.currentType].stop = true;
                } else {
                    this.spiralRight();
                }

            }, response => {
                console.log('Some error with ' + this.currentType + ' api!');
            });
        },

        setBulletinsToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections[this.currentType].stop) return false;

            this.flag = true;
            
            this.hideToolTip();

            this.$http.get('/api/v1/' + this.currentType + this.addRoute + '/20/' + this.sections[this.currentType].offset).then(response => {
                this.sections[this.currentType].offset += 20;

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
                    this.sections[this.currentType].stop = true;
                } else {
                    this.spiralRight();
                }
                
            }, response => {
                console.log('Some error with '+ this.currentType +' api!');
            });
        },

        setProductsToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.sections[this.currentType].stop) return false;

            this.flag = true;
            
            this.hideToolTip();
            
            this.$http.get('/api/v1/products/' + this.currentProductType + '/20/' + this.sections[this.currentType].offset).then(response => {
                this.sections[this.currentType].offset += 20;

                if (response.body.status === "OK") {
                    let products = response.body.products;
                    last_num = this.products[this.products.length - 1].num;

                    products.map(function (item) {
                        item.size = item.sizes.split('|');
                        if (item.extra_images) {
                            item.extra = item.extra_images.split('|');
                        }
                        return item;
                    });
                    this.hideToolTip();
                    
                    ln = products.length;
                    for (var i = 0; i < ln; i++) {
                        ++last_num;
                        products[i].num = last_num;
                    }
                    products = this.products.concat(products);

                    this.products = products;
                    this.flag = false;                

                    if (response.body.count == 0){
                        this.sections[this.currentType].stop = true;
                    } else {
                        this.spiralRight();
                    }
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with ' + this.currentType + ' api',
                        duration: 10000,
                    });
                }
            }, response => {
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with ' + this.currentType + ' api',
                    duration: 10000,
                });
            });
        },

        prepareCreations: function(event) {
            this.creationsList = event.target.files;
            this.setImageNames();
        },

        setImageNames: function() {
            var ln = this.creationsList.length;
             $('.image-preview input[type="text"]').val(" ");
            for (var key = 0; key < ln; key++) {
                var val = $('.image-preview input[type="text"]').val(); 

                $('.image-preview input[type="text"]').val( val + " " + this.creationsList[key].name + ", ");

                if (key == ln-1) $('.image-preview input[type="text"]').val( val + " " + this.creationsList[key].name);
            }
        },

        uploadCreations: function(index = 0) {
            if (this.creationsList.length == 0) {
                this.$notify.error({
                    title: 'Error',
                    message: 'Please select Images',
                    duration: 10000,
                });
                return false;
            }
            $('#upload-progress').show();
            if (index >= this.creationsList.length) {
                this.creationsList = [];
                setTimeout(this.hideProgressBar, 500);
                this.$notify.success({
                    title: 'Success',
                    message: 'Images successfully uploaded',
                    duration: 10000,
                });

                return this.imageLoad('creations', 50, false);
            }

            var data = new FormData();

            data.append("image", this.creationsList[index]);
            
            var self = this;
            var cat_id = this.currentUploadCategory == '' ? 0 : this.currentUploadCategory;

            this.$http.post('/dashboard/images/' + cat_id, data, {
                progress(e) {
                    if (e.lengthComputable) {
                        var percent = (e.loaded / e.total) * 100;
                        self.setBeforeProgressBar(percent, index);
                    }
                }
            }).then(response => {
                ++index;
                this.uploadCreations(index);
            }, response => {
                this.$notify.error({
                    title: 'Error',
                    message: response.body,
                    duration: 10000,
                });
                setTimeout(this.hideProgressBar, 500);
            });
              
        },

        setBeforeProgressBar: function(percent, index) {
            var wd =  (index/ this.creationsList.length) * 100;

            wd += ((percent/100) * (1/ this.creationsList.length)) * 100; 
            $('#upload-progress>.progress-bar').attr('style', 'width: ' + wd + '%');
        },
        

        hideProgressBar: function() {
            $('#upload-progress').hide();
           
            $('#upload-progress>.progress-bar').attr('style', 'width: 0%');
        },
        

        homeLoad: function() {
            this.getImages();
        },

        instagramLoad: function() {
            this.loading = true;
            this.hideToolTip();     
            
            this.images = this.defaultInsta;
            
			var self = this;
            this.sections.instagram.max_id = 0;

            this.$http.post('/api/v1/images/instagram', {max_id: this.sections.instagram.max_id, count: 50}).then(response => {
                if (response.body.status === "OK") {
                    this.showMenu = true;
                    this.arrowEnable = true;
                    this.currentSection = 'instagram';
                    this.currentType = 'instagram';
                    this.images = response.body.images.map(function (item) {
						item.tmpName = item.name;
						item.name = 'upload/thumbs/logo-phase2.gif';
						
						return item;
					});
                    this.hideToolTip(); 
					setTimeout(function() {
						self.images.map(function(item) {
							item.name = item.tmpName;
							return item;
						});
					}, 500)					

                    this.sections.instagram.max_id = response.body.max_id;
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with instagram api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with instagram  api',
                    duration: 10000,
                });
             });
        },

        imageLoad: function(type, count = 50, menu = true, additional = '', currentSection = 'images') {
            this.loading = true;
            this.hideToolTip();     
            this.sections[type].offset = 0;
			var self = this;
			
            this.$http.get('/api/v1/' + type + '/' + count + '/' + this.sections[type].offset).then(response => {
                this.sections[type].offset = count;
                this.arrowEnable = true;
                this.showMenu = menu;

                if (response.body.status === "OK") {
                    this.images = response.body.images.map(function (item) {
						item.tmpName = item.name;
						item.name = 'logo-phase2.gif';
						item.tmpNail = item.thumbnail
						item.thumbnail = 'upload/thumbs/logo-phase2.gif';
						
						return item;
					});
                    this.additionalCurrentType = additional;                    
                    this.hideToolTip();   

					setTimeout(function() {
						self.images.map(function(item) {
							item.name = item.tmpName;
							item.thumbnail = item.tmpNail;
							return item;
						});
					}, 500)	

                    this.currentSection = currentSection;
                    this.currentType = type;
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with ' + type + ' api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with ' + type + ' api',
                    duration: 10000,
                });
             });
        },

        settingsOpen: function() {
            this.showMenu = false;
            this.arrowEnable = false;            
            this.currentSection = 'settings';
        },

        editAge: function() {
            this.ageEdit = true;
        },

        editName: function() {
            this.nameEdit = true;
            $('.js-name').focus();
        },

        editBio: function() {
            this.bioEdit = true;
        },

        avatarChange: function() {
            let data = new FormData;

            data.append('avatar', $('.avatar-input')[0].files[0]);

            this.loading = true;

            this.$http.post('/api/v1/settings/avatar', data).then(response => {
                this.loading = false;
                this.bioEdit = false;
                this.avatarPreview = response.body.avatar;                
                $('.avatar-input').val('');
                $('.avatar-view-preview').attr('src', 'upload/avatars/' + response.body.avatar);                

                this.$notify.success({
                    title: 'Success',
                    message: 'Avatar has been successfully updated',
                    duration: 10000,
                });

            }, response => {
                this.loading = false;    
                if (response.status === 422) {
                    return this.$notify.error({
                        title: 'Error',
                        message: response.body.message,
                        duration: 10000,
                    });
                }

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with settings api',
                    duration: 10000,
                });
             });
        },

        saveBio: function() {
            let bio = $('.js-bio').val();
            
            if (bio === '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Invalid biography',
                    duration: 10000,
                });
            }

            this.loading = true;

            this.$http.post('/api/v1/settings/bio', {bio: bio}).then(response => {
                this.loading = false;
                this.bioEdit = false;

                $('.js-bio').text(response.body.bio);                                
                $('.js-s-bio').text(response.body.croppBio);

                this.$notify.success({
                    title: 'Success',
                    message: 'Bio has been successfully updated',
                    duration: 10000,
                });
            }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with settings api',
                    duration: 10000,
                });
             });
        },

        saveName: function() {
            let name = $('.js-name').val();
            
            if (name === '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Invalid name',
                    duration: 10000,
                });
            }

            this.loading = true;

            this.$http.post('/api/v1/settings/name', {name: name}).then(response => {
                this.loading = false;
                this.nameEdit = false;
                
                $('.js-s-username').text(response.body.name);

                this.$notify.success({
                    title: 'Success',
                    message: 'Name has been successfully updated',
                    duration: 10000,
                });
            }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with settings api',
                    duration: 10000,
                });
             });
        },

        saveAge: function() {
            let day = $('.js-age-day').val(),
                month = $('.js-age-month').val(),            
                year = $('.js-age-year').val(),
                date = month + '-' + day + '-' + year,                
                dateObj = new Date(month + '-' + day + '-' + year);
            
            if (dateObj === 'Invalid Date') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Invalid date',
                    duration: 10000,
                });
            }

            this.loading = true;

            this.$http.post('/api/v1/settings/age', {date: date}).then(response => {
                this.loading = false;
                this.ageEdit = false;
                $('.js-age-day').val(day);
                $('.js-age-month').val(month);
                $('.js-age-year').val(year);
                
                $('.js-age').text(response.body.age);

                this.$notify.success({
                    title: 'Success',
                    message: 'Age has been successfully updated',
                    duration: 10000,
                });
            }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with settings api',
                    duration: 10000,
                });
             });
        },

        bulletinLoad: function(type, count = 50, menu = true, additional = '', addRoute = '') {
            this.loading = true;
            this.hideToolTip();            
            this.sections[type].offset = 0;
            var self = this;

            this.$http.get('/api/v1/' + type + addRoute + '/' + count + '/' + this.sections[type].offset).then(response => {
                this.sections[type].offset = count;
                this.arrowEnable = true;
                this.showMenu = menu;
            
                if (response.body.status === "OK") {
                    this.bulletins = response.body.bulletins.map(function (item) {
						//item.tmpImage = item.image;
						//item.image = 'logo-phase2.gif';
						
						return item;
					});
                    this.additionalCurrentType = additional;
                    this.addRoute = addRoute;

					
                    if (type === 'team') {
                        this.currentSection = 'team';      
						setTimeout(function() {
							self.bulletins.map(function(item) {
								//item.image = item.tmpImage;
								return item;
							});
						}, 500)							
                    }else {
                        this.currentSection = 'bulletins';                        
                    }

                    this.currentType = type;                    
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with ' + type + ' api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with ' + type + ' api',
                    duration: 10000,
                });
             });
        },

        productsLoad: function(type, count = 50, menu = true, additional = '') {
            this.loading = true;
            this.hideToolTip();
            let subType = type;
            this.currentProductType = type;
			var self = this;
            this.sections.products.offset = 0;

            this.$http.get('/api/v1/products/' + subType + '/' + count + '/' + this.sections.products.offset).then(response => {
                this.sections.products.offset = count;
                this.arrowEnable = true;
                this.showMenu = menu;

                if (response.body.status === "OK") {
                    this.products = response.body.products;

                    this.products.map(function (item) {
						item.tmp = item.photo_wcloud;
						item.photo_wcloud = 'upload/thumbs/logo-phase2.gif';
                        item.size = item.sizes.split('|');
                        if (item.extra_images) {
                            item.extra = item.extra_images.split('|');
                        }
                        return item;
                    });
                    this.hideToolTip();
                    
					setTimeout(function() {
						self.products.map(function(item) {
							item.photo_wcloud = item.tmp;
							return item;
						});
					}, 500)	
                    this.additionalCurrentType = additional;                    

                    this.currentSection = 'products';
                    this.currentType = 'products';
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with products api',
                        duration: 10000,
                    });
                }
                
                this.loading = false;
             }, response => {
                this.loading = false;    

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with products api',
                    duration: 10000,
                });
             });
        },

        openLocation: function() {
            this.currentSection = 'location';
            this.currentType = 'location';

            this.bulletins = [
                {
                    data: 'Address',
                    extra: '12437 Lewis Street Suite 100, Garden Grove CA 92840',
                    num: 1
                }
            ]
        },

        openProductCloud: function(key) {
            this.currentProduct = this.products[key];

            $("#product-cloud")
                .css("display", "flex")
                .hide()
                .fadeIn(500);
        },

        openCloud: function(key) {
            if (typeof this.bulletins[key].extra == 'undefined') {
                this.cloudData.text = '';
            } else {
                this.cloudData.text = this.bulletins[key].extra;
            }
                this.cloudData.title = this.bulletins[key].data;

            this.cloudData.open = true;

            $("#def-cloud")
                .css("display", "flex")
                .hide()
                .fadeIn(500);
        },

        openLocationCloud: function() {
            this.currentSection = 'location';
            this.currentType = 'location';
            this.showAllMenu = false;
        },

        changeMenuState: function() {
            this.showAllMenu = !this.showAllMenu;
        },

        closeLocationCloud: function() {
            $("#location-cloud")
            .fadeOut(500);
        },

        openTeamCloud: function(key) {
            this.teamCloudData = this.bulletins[key];

            $("#team-cloud")
                .css("display", "flex")
                .hide()
                .fadeIn(500);
        },

        closeTeamCloud: function () {
            $("#team-cloud")
            .fadeOut(500);
        },

        closeProductCloud: function () {
            $("#product-cloud")
            .fadeOut(500);
        },


        closeCloud: function () {
            this.cloudData.open = false;
            $(".wrap-cloud")
            .fadeOut(500);
        },

       

        spiralRight: function() {
            last = Number($('.panels div:last').attr('data-pos')) - 1;
            self = this;
            cat_id = $('#select-cat').val();
            if (cat_id == '0') cat_id = 'all';

            if (this.flag) return false;
            
            if (last < 9 && !this.flag) {
                switch (this.currentSection) {
                    case 'videos':
                    case 'images':
                        this.setImageToPanels(last + 1, cat_id);
                        break;
					case 'team':
                    case 'bulletins':
                        this.setBulletinsToPanels(last + 1, cat_id);
                        break;
                    case 'products':
                        this.setProductsToPanels(last + 1, cat_id);
                        break;
                    case 'instagram': 
                        //this.setInstaToPanels(last + 1, cat_id);
                        break;
                }
            } 

            if (last > 0) {
                if (this.currentSection == 'images' || this.currentSection == 'instagram' || this.currentSection == 'videos') {
                    ln = this.images.length;
                    images = this.images;
                    for(var i = 0; i < ln; i++) {
                        images[i].num -= 1;
                    }
                    this.images = images;
                }

                if (this.currentSection == 'bulletins' || this.currentSection == 'team') {
                    ln = this.bulletins.length;
                    bulletins = this.bulletins;
                    for(var i = 0; i < ln; i++) {
                        bulletins[i].num -= 1;
                    }

                    this.bulletins = bulletins;
                    
                }

                if (this.currentSection == 'products') {
                    ln = this.products.length;
                    products = this.products;
                    for(var i = 0; i < ln; i++) {
                        products[i].num -= 1;
                    }

                    this.products = products;
                    
                }
            }
        },

        spiralLeft: function() {
            first = Number($('.panels div:first-child').attr('data-pos'));
            if (first < 1) {
                if (this.currentSection == 'images' || this.currentSection == 'instagram' || this.currentSection == 'videos') {
                    ln = this.images.length;
                    images = this.images;
                    for(var i = 0; i < ln; i++) {
                        images[i].num += 1;
                    }
                    
                    this.images = images;
                }
                if (this.currentSection == 'bulletins' || this.currentSection == 'team') {
                    ln = this.bulletins.length;
                    bulletins = this.bulletins;
                    for(var i = 0; i < ln; i++) {
                        bulletins[i].num += 1;
                    }

                    this.bulletins = bulletins;
                    
                }
                if (this.currentSection == 'products') {
                    ln = this.products.length;
                    products = this.products;
                    for(var i = 0; i < ln; i++) {
                        products[i].num += 1;
                    }

                    this.products = products;
                    
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

        sendInvite: function() {
            if (this.recEmail === '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Email is required field',
                    duration: 10000,
                });
            }
            this.loading = true;       

            this.$http.post('/api/v1/invite/send', {email: this.recEmail}).then(response => {
                this.loading = false;
                this.inviteSend = false;

                this.$notify.success({
                    title: 'Success',
                    message: 'Invite was sent successfully',
                    duration: 10000,
                });
                this.userInvites = response.body.invites;

                console.log(response.body.invites);

            }, response => {
                this.loading = false;
                
                if (response.status === 422) {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.message,
                        duration: 10000,
                    });
                }else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Some error with invites api',
                        duration: 10000,
                    });
                }
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

        openVideo: function(code) {
            this.openVideoIndicator = true;
            this.currentVideoCode = code;
        },
        markerClick: function() {
            this.zoom = 17;
            this.center = {lat:33.782085,lng:-117.897881};
            this.$refs.gmap.$mapObject.setZoom(this.zoom );
            this.$refs.gmap.$mapObject.setCenter(this.center);     
            this.infoWinOpen = true;       

        }

     }
}) 