Vue.component('main-page', {
    data: function () {
        return {
            categories: [],
            images: [],
            offset: 0,
            flag: 0,
            flagMany: 0,            
            spiral: 0,
            insta: 0,
            counter: 0,
            itemsOnPage: 10,
            itemsTmp: 0,
            stop: 0,
            instaProgress: 0,
            sections: [],
            bitcoinData: {},
            section: false,
            animation: false,
            loading: false,
        }
    },
    mounted: function() {
        this.getCategories();
        this.getImages();
        
    },
    methods: {
        getCategories: function() {
            this.$http.get('/api/v1/categories').then(response => {
                this.categories = response.data;
            }, response => {
                console.log('Some error with categories api!');
            });
        },

        getImages: function(cat_id = 'all', count = 70, cat = false) {
            if (cat) this.hideCat();
           
            if (cat_id == '0') cat_id = 'all';

            this.$http.get('/api/v1/images/' + cat_id + '/' + count + '/0').then(response => {
               if (cat) this.showCat();
                this.images = response.data;
                this.offset = 50;
            }, response => {
                console.log('Some error with images api!');
            });
        },

        getInstaImages: function () {
            if (this.section) return false;
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
        },

        setImageToPanels: function(last, cat_id = 'all') {
            if (this.flag || this.stop) return false;

            this.flag = 1;
            this.hideNav();
            
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
                images =  this.images.concat(images);

                this.images = images;

                this.flag = 0;
                this.showNav();
                this.spiralRight();
            }, response => {
                console.log('Some error with images api!');
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

        getBicoinCash: function() {
        if (this.bitcoinData.bid) {return false};
            this.hideBtc();
            this.$http.get('/api/v1/bitcoins/ticker').then(response => {
                this.bitcoinData = response.body;
                this.showBtc();
            }, response => {
                console.log('Some error with images api!');
            });

        },
        
        hideNav: function() {
            $('.button-nav').hide();
            $('.spiral-nav').hide();
            $('.preloader').fadeIn('slow');
        },

        showNav: function() {
            $('.preloader').hide();
            $('.button-nav').fadeIn('slow');
            $('.spiral-nav').fadeIn('slow');
        },

        hideBtc: function() {
            $('.button-nav').css('position', 'absolute').hide();
            $('#bitcoin-section').hide();
            setTimeout(function() {
                $('.preloader').fadeIn('slow');
            }, 1000);
        },

        showCat: function() {
           // setTimeout(function() {
                $('.preloader').hide();
                $('#category-section').fadeIn('slow');
             //}, 1000);
        },

        hideCat: function() {
            $('#category-section').hide();
            //setTimeout(function() {
                $('.preloader').fadeIn('slow');
           // }, 00);
        },

        showBtc: function() {
          setTimeout(function() {
                $('.preloader').hide();
                $('#bitcoin-section').fadeIn('slow');
            }, 1000);
        },


        showCanvas: function() {
            $('.main-navigation').fadeOut();
            $('.main-canvas').css("display", "flex")
                            .hide()
                            .fadeIn();
        },

        showSection: function(section, left) {

            if (this.animation) return false;
            this.animation = true;

            if (this.sections[section]) {
                this.hideSection(section);
                return false;
            }

            if (this.section) return false;

            this.section = true;

            if (section == 'bitcoin')  this.getBicoinCash();

            this.sections[section] = true;

            var selectSection = section + '-section';
            section += '-nav';
            left = left + '%';

            $('.button-sections').css('z-index', 2);

            //hide buttons nav
            $('.button-nav').css({'position':'absolute', 'display': 'none'});
            
            $('.button-nav').children('div:not(#' + section + ')').animate({opacity: 0}, 500);
            $('#' + section).animate({'left': left}, 1000).animate({opacity: 0}, 800);

           // $('#' + section).animate({'top': '-58%'}, 500).animate({ 'left': left}, 500).css('z-index', 100);

            var self = this;
            setTimeout(function() {
                $('#' + selectSection).fadeIn('slow');
                self.animation = false;
            }, 2000);

            
        },

        hideSection: function(section) {
            
            this.section = false;

            this.sections[section] = false;

            showSection = section + '-section';
            section += '-nav';
            setTimeout(function() {
                $('#' + showSection).fadeOut('slow');
            }, 100);
            $('.button-sections').css('z-index', 0);
            $('.button-nav').children('div:not(#' + section + ')').animate({opacity: 1}, 1000);

            $('#' + section).animate({'left': '0'}, 500).animate({ 'top': '0'}, 500).css('z-index', 1);

             var self = this;

            setTimeout(function() {
                 self.animation = false;
            }, 550);
           
        },

        showToolTip: function(event, index) {
            if (window.main_flag) return false;
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

        showRegister: function() {
            //$('#members-section').animate({opacity: 0}, 1000);
            $('#members-section').animate({ opacity: 1}, 1000).hide();

            setTimeout(function() {
                $('#register-section').fadeIn();
           }, 550);
        },

        showRegisterActivate: function() {
            //$('#register-section').animate({opacity: 0}, 1000);

            $('#register-section').animate({ opacity: 0 }, 1000).hide();

            setTimeout(function() {
                $('#register-active-section').fadeIn();
           }, 550);
        },

        hideRegisterActivate: function() {
            $('#register-active-section').animate({ opacity: 0 }, 1000).hide();

            setTimeout(function() {
                $('#members-section').fadeIn();
           }, 550);
        },

        loginUser: function(form) {
            this.loading = true;

            var data = new FormData();


            data.append('email', $(form).find('input[name="email"]').val());
            data.append('password', $(form).find('input[name="password"]').val());
            data.append('remember', $(form).find('input[name="remember"]').val());
            

            this.$http.post('/login', data).then(response => {
                this.loading = false;                
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'You have successfully entered',
                        duration: 10000,
                      });
                    
                      window.location.href = "/dashboard";
                    
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.errors,
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;                                
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with login api',
                    duration: 10000,
                  });
            });
        },

        registerUser: function(form) {
            this.loading = true;

            var data = new FormData();

            data.append('name', $(form).find('input[name="name"]').val());
            data.append('first_name', $(form).find('input[name="first_name"]').val());
            data.append('last_name', $(form).find('input[name="last_name"]').val());
            data.append('email', $(form).find('input[name="email"]').val());
            data.append('password', $(form).find('input[name="password"]').val());
            data.append('password_confirmation', $(form).find('input[name="password_confirmation"]').val());
            
            this.$http.post('/register', data).then(response => {
                this.loading = false;
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Enter the code you receive on the email',
                        duration: 10000,
                      });
                    this.showRegisterActivate();
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.errors,
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with register api',
                    duration: 10000,
                  });
            });
           /* this.$http.post('/register', {'images': images}).then(response => {
                a = window.location.replace("http://create.badge-m.com/download");
                $('.canvas-mask').fadeOut('slow');
                $('.canvas-loader').fadeOut('slow');
            }, response => {
                console.log('Some error with images api!');
            });*/
        },

        activateAccount: function() {
            this.loading = true;
            var code = $('input[name="code"]').val();
            this.$http.post('/activate', {code: code}).then(response => {
                this.loading = false;
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Your account has been successfully activated',
                        duration: 10000,
                      });

                    this.hideRegisterActivate();
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'You entered an invalid code by try again',
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with register api',
                    duration: 10000,
                  });
            });
        }
    }
}) 