@extends('layouts.app')

@section('content')
    <div id="app" v-cloak>
        <main-page inline-template >
            <div>
                <div class="main-navigation-wrap" >
                    <div class="main-menu-layer1">
                        <div class="home-menu animated" @click="homeLoad"></div>                       
                        <div class="insta-menu animated" @click="instagramLoad"></div>
                        <div class="rocket-menu animated" @click="productsLoad('all', 50, false)"></div>                                                                     
                    </div>
                    <div class="main main-navigation-2"  v-loading="loading">
                        <div class="row main-navigation-header" v-if="showMenu">
                            <div class="col-md-9 welcome-text">
                                Hello, {{ Auth::user()->name }}!
                            </div>
                            <div class="col-md-3 pull-right message ">
                                <img class="col-md-6 message-image animated" src="{{ asset('img/msg-phase2.png') }}" />
                                <span class="message-text col-md-6">
                                    (3)
                                </span>
                            </div>
                        </div>    
                        <div class="row main-navigation-body" v-if="showMenu">
                            <div class="row" >
                                <div class="col-md-6 bulletin" @click="bulletinLoad('bulletins' , 50)">
                                    <img class="col-md-4 bulletin-image animated" src="{{ asset('img/bulletin-phase2.png') }}" />
                                    <span class="bulletin-text col-md-6">
                                        Bulletin
                                    </span>
                                </div>
                                <div class="col-md-6 creations  pull-right" @click="imageLoad('creations' , 50)">
                                    <img class="col-md-4 creations-image animated" src="{{ asset('img/creations-phase2.png') }}" />
                                    <span class="creations-text col-md-6">
                                        Creations
                                    </span>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6 favorites" @click="imageLoad('favorites', 50)">
                                    <img class="col-md-4 favorites-image animated" src="{{ asset('img/favorites-phase2.png') }}" />
                                    <span class="favorites-text col-md-6">
                                        Favorites
                                    </span>
                                </div>
                                <div class="col-md-6 history"  @click="imageLoad('histories', 50)">
                                    <img class="col-md-4 history-image animated" src="{{ asset('img/history-phase2.png') }}" />
                                    <span class="history-text col-md-6">
                                        History
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row store-section" v-if="currentSection == 'products'" style="text-align: center">
                            <div class="col-md-12 font-size50" @click="productsLoad('cap', 50, false)">
                                Caps
                            </div>
                            <div class="col-md-12 font-size50" @click="productsLoad('t-shirt', 50, false)">
                                T-shirts
                            </div>
                            <div class="col-md-12 font-size50" @click="productsLoad('badge', 50, false)">
                                Badges
                            </div>
                            <div class="col-md-12 font-size50" @click="productsLoad('book', 50, false)">
                                Books
                            </div>
                        </div>
                        <div class="row category-section" v-if="additionalCurrentType == 'category' && showMenu == false">
                            <span class="title">Category Search</span>
                            <div class="select-box">
                                <select id="select-cat" class="category-selecter" name="searchCate" @change="getImages($event.target.value, 50, false, 'category')">
                                    <option value="0">All</option>       
                                    <option :value='category.id' v-for='category in categories'>@{{ category.name }}</option>                             
                                </select>
                            </div>
                        </div>
                        <div class="row faq-section" v-if="additionalCurrentType == 'aboutUs' && showMenu == false">
                            <div class="row faq-description col-md-12">
                                <div class="col-md-12" v-if="currentType === 'faq'">
                                    Freely scroll through the frequently asked questions on our carousel.
                                </div>
                                <div class="col-md-12" v-if="currentType === 'location'">
                                    Address 12437 Lewis Street Suite 100, Garden Grove CA 92840
                                </div>
                                <div class="col-md-12" v-if="currentType === 'goals'">
                                </div>
                                <div class="col-md-12" v-if="currentType === 'team'">
                                    Our best team
                                </div>
                            </div>
                            <div class="row faq-menu">
                                <div class="col-md-12 faq-item">
                                    <div class="col-md-4">
                                        <a @click="bulletinLoad('team', 50, false, 'aboutUs')"> Team </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a @click="openLocation"> Location</a>
                                    </div>
                                    <div class="col-md-4">
                                        <a @click="bulletinLoad('goals', 50, false, 'aboutUs')"> Goals</a>
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        
                        <div class="drop-me">
                            <p>Drop me Here</p>
                        </div>
                    </div>
                    <div class="main-menu-layer2">
                        <div class="diamond-menu animated" @click="imageLoad('videos', 50, true, '', 'videos')"></div>
                        <div class="paint-menu animated" @click="getImages('all', 50, false, 'category')"></div>       
                        <div class="zoom-menu animated" @click="bulletinLoad('faq', 50, false, 'aboutUs')"></div>                                                                 
                    </div>
                    <div class="main-menu-layer3">
                        <div class="left-many animated" @click="spiralManyLeft"></div>
                        <div class="left-single animated" @click="spiralLeft"></div>
                        <div class="right-single animated" @click="spiralRight"></div>
                        <div class="right-many animated" @click="spiralManyRight"></div>  
                    </div>
                    
                </div>
                
               
                <div class="main-canvas">
                    
                    <div class="scale-line">
                        <div class="scale-back">
                            <div id="canvas-line" class="scale-line-front" ondragstart="return false;" >
                                <div id="canvas-scale" onmousedown="canvasScale(event, $(this))" class="scale-btn"></div>
                            </div>
                        </div>
                    </div>
                    <div class="canvas" ondragstart="return false;" onmousedown="hideLatest()">
                        <div class="canvas-mask"></div>
                        <div class="preloader text-center canvas-loader">
                            <div id="preloader_1">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div> 

                    </div>
                    <div class="canvas-btn">
                        <div class="canvas-btn-home" onclick="canvasHide()" ></div>
                        <div class="canvas-btn-scale" @click="savePNG"></div>
                        
                    </div>
                   
                </div>

                <div class="panels">
                    <template v-if="currentSection === 'images'">
                        <div :id='"img-"+image.id' :class='"panel pos"+image.num+" canva-img"' v-for='(image, key) in images' :data-pos="image.num" >
                            <div class="image-wrap" @mouseenter="showToolTip($event, key)" @mouseleave="hideToolTip($event, key)" :data-pos="image.num">
                                <img onmousedown='panelImg(event, $(this))' :src='"upload/thumbs/" + image.name'  :data-pos="image.num" :data-id="image.id"  />
                                <el-tooltip class="item" effect="dark" content="Remove from favorites" v-if="image.favorite" placement="top">
                                    <i class="fa fa-heart favorite-heart"  @click="removeFromFavorited(image.id, key)"></i>    
                                </el-tooltip>
                                <el-tooltip class="item" effect="dark" content="Add to favorites" v-else placement="top">
                                    <i class="fa fa-heart-o favorite-heart "  @click="addToFavorited(image.id, key)"></i>      
                                </el-tooltip>                              
                            </div>   
                        </div>
                    </template>
                    <template v-if="currentSection === 'videos'">
                        <div :id='"img-"+video.id' :class='"panel pos"+video.num+" canva-img video-block"' v-for='(video, key) in images' :data-pos="video.num" >
                            <div class="image-wrap" :data-pos="video.num">
                                <img :src='video.thumbnail' @click="openVideo(video.video_id)" class="video-thumb"  :data-pos="video.num" :data-id="video.id"  />      
                                <i class="fa fa-youtube-play video-play" @click="openVideo(video.video_id)"  aria-hidden="true"></i>                                                      
                            </div>   
                        </div>
                    </template>
                    <template v-if="currentSection === 'instagram'">
                        <div :id='"img-"+image.id' :class='"panel pos"+image.num+" canva-img"' v-for='(image, key) in images' :data-pos="image.num" >
                            <div class="image-wrap"  :data-pos="image.num">
                                <img class="insta-img" onmousedown='panelImg(event, $(this))' :src='image.name'  :data-pos="image.num" :data-id="image.id" />
                                                           
                            </div>   
                        </div>
                    </template>
                    <template v-if="currentSection === 'products'">
                        <div :id='"img-"+image.id' :class='"panel pos"+image.num+" product-img"' v-for='(image, key) in products' :data-pos="image.num" >
                            <div class="product-wrap"  :data-pos="image.num">
                                <img @click="openProductCloud(key)" :src='image.photo_wcloud'  :data-pos="image.num" :data-id="image.id" />
                            </div>   
                        </div>
                    </template>
                    <template v-if="currentSection === 'bulletins'">
                        <div :id='"bulletin-"+key' :class='"panel pos"+bulletin.num+" cloud-img"' v-for='(bulletin, key) in bulletins' :data-pos="bulletin.num"  :data-id="key" @click="openCloud(key)">
                            <span>@{{ bulletin.data }}</span>
                        </div>
                    </template>
                    <template v-if="currentSection === 'team'">
                        <div 
                            :id='"bulletin-"+key' 
                            :class='"panel pos"+bulletin.num+" cloud-img"' 
                            v-for='(bulletin, key) in bulletins' 
                            :data-pos="bulletin.num"  
                            :data-id="key" 
                            @click="openTeamCloud(key)"
                            :style="'background-image: url(/upload/team/thumbs/' + bulletin.image + ');'"
                        >
                        </div>
                        
                    </template>
                    <template v-if="currentSection === 'location'">
                        <div 
                            :id='"bulletin-"+key'
                            :class='"panel pos"+bulletin.num+" cloud-img"'
                            v-for='(bulletin, key) in bulletins'
                            :data-pos="bulletin.num"
                            :data-id="key"
                            @click="openLocationCloud(key)"
                            
                        >
                            <span>Position on Map</span>
                        </div>
                    </template>
                </div>
                <div id="bottom-nav">
                    <div class="bottom-trigger" onmouseenter="botTrigerEnter()" onmouseleave="botTrigerLeave()" onclick="botMenuOpen()">
                    Tools 
                    </div>
                    <div class="bottom-menu">
                        <div class="btn-bot-nav">
                            <div class="col-md-2 col-md-offset-1 self-bot-nav bot-right" @click="spiralLeft">
                                <img src="{{ asset('img/self-left-tool.png') }}" />                                
                            </div>
                            <div class="col-md-2 many-bot-nav bot-right" @click="spiralManyLeft">
                                <img src="{{ asset('img/many-left-tool.png') }}" />                                
                            </div>
                            <div class="col-md-2 space-bot many-bot-nav bot-left" @click="spiralManyRight">
                                <img src="{{ asset('img/many-right-tool.png') }}" />                                
                            </div>
                            <div class="col-md-2 self-bot-nav bot-left" @click="spiralRight">
                                <img src="{{ asset('img/self-right-tool.png') }}" />                                
                            </div>
                        </div>
                    </div>
                </div>
                <div id="location-cloud" class="wrap-cloud">
                    <div class="open-cloud" style="background-image: url(/img/map-cloud.png)">   

                        <div class="location-text">
                       </div>                                  
                        <div class="cloud-close" @click="closeLocationCloud">
                            X
                        </div>
                    </div>
                </div>
                <div id="def-cloud" class="wrap-cloud" >
                    <div class="open-cloud" :style="(currentSection === 'location') ? 'background-image: url(/img/map-cloud.png)' : ''">                                    
                        <div class="cloud-header">
                            @{{ cloudData.title }}
                        </div>
                        <div class="cloud-text">
                            @{{ cloudData.text }}
                        </div>
                        <div class="cloud-close" @click="closeCloud">
                            X
                        </div>
                    </div>
                </div>
                <div id="team-cloud" class="wrap-cloud" >
                    <div class="open-cloud" >
                        <div class="team-cloud-header">
                            <img style="max-height: 200px;width: auto;display: block;" v-if="teamCloudData.image" :src="'upload/team/' + teamCloudData.image" />

                            @{{ teamCloudData.first_name }} @{{ teamCloudData.last_name }}
                        </div>
                        <div class="cloud-text">
                            @{{ teamCloudData.description }}
                        </div>
                        <div class="cloud-close" @click="closeTeamCloud">
                            X
                        </div>
                    </div>
                </div>
                <div id="product-cloud" class="wrap-cloud" >
                    <div class="open-cloud product-cloud">
                        <div class="team-cloud-header product-header">
                            <el-carousel trigger="click" style="max-height: 300px; min-width: 400px" indicator-position="none" arrow="always" :autoplay="false">
                                <el-carousel-item >
                                    <img style="max-height: 300px;display: block;" :src="currentProduct.photo" /> 
                                </el-carousel-item>
                                <el-carousel-item v-for="item in currentProduct.extra" :key="item" v-if="currentProduct.extra[0]">
                                    <img style="max-height: 300px;display: block;" :src="item" />                                    
                                </el-carousel-item>
                            </el-carousel>
                        </div>
                        <div class="cloud-store">
                            <el-button icon="el-icon-goods" type="info" style="font-size: 20px;" round>To Cart</el-button>
                        </div>
                        <div class="cloud-story">
                            @{{ currentProduct.story }}
                        </div>

                        <div class="cloud-price">
                            Price: </br>
                            @{{ currentProduct.price }} <span class="currency">$</span>
                        </div>

                        <div class="cloud-name">
                            @{{ currentProduct.name }}
                        </div>

                        <div class="cloud-size">
                            Select size and quantity: </br>
                            <select>
                                <option v-for="size in currentProduct.size" :value="size">@{{ size }}</option>                                
                            </select>

                            <select>
                                <option v-for="n in 10" :value="n">@{{ n }}</option>                                
                            </select>
                        </div>

                        <div class="cloud-close" @click="closeProductCloud">
                            X
                        </div>
                    </div>
                </div>
                <div id="youtube-video" v-if="openVideoIndicator">
                    <i class="fa fa-times " @click="openVideoIndicator = false"  aria-hidden="true"></i>                                                      
                    <iframe
                        :src="'https://www.youtube.com/embed/' + currentVideoCode">
                    </iframe>
                </div>
            </div>
       </main-page>
    </div>
@endsection

@section('custom-css')
    <style>
        .el-carousel__container {
            height:300px !important;
        }
        .el-carousel__arrow {
            background-color: rgba(21, 128, 255, 0.53);
            color: #fff;
            position: absolute;
            top: 50%;
        }
    </style>
@endsection