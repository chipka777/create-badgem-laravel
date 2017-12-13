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
                image = {
                    'height': ((Math.round($(this).height() / $(this).parent().height() * 100) * 768)/100),
                    'width': ((Math.round($(this).width() / $(this).parent().width() * 100) * 1152)/100),
                    'rotate': getRotationDegrees($(this)),
                    'src': $(this).children('img').attr('src'),
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

            showSection = section + '-section';
            section += '-nav';
            left = left + '%';

            $('.button-sections').css('z-index', 2);

            $('.button-nav').children('div:not(#' + section + ')').animate({opacity: 0}, 1000);

            $('#' + section).animate({'top': '-58%'}, 500).animate({ 'left': left}, 500).css('z-index', 100);

            var self = this;
            setTimeout(function() {
                $('#' + showSection).fadeIn('slow');
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
            
            $('body').prepend('<div id="tooltip" style="'+style+'">Created: '+ date +' <br/> Author: '+img.user+' <br/> Favorited : 0</div>');

            $('html').on('mousemove', function(event) {
                $('#tooltip').css({'top': event.pageY + 10, 'left': event.pageX + 10});
            });

            
          
        },

        hideToolTip: function(event, index) {
            if (window.main_flag) return false;
            $('html').off('mousemove');

            $('#tooltip').remove();
        }
    }
}) 