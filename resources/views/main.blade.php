@extends('layouts.app')

@section('content')
    <div id="app" v-cloak>
        <main-page inline-template >
            <div>
                <div class="main-navigation-wrap" v-if="showAllMenu">
				<img class="hidden" src="upload/thumbs/logo-phase2.gif" >
				<img class="hidden" src="upload/team/thumbs/logo-phase2.gif" >
                <input hidden class="user-invites" value="{{ Auth::user()->settings !== null && Auth::user()->settings->invites !== null ? Auth::user()->settings->invites : 0}}">
                <span class="hidden avatar-src">{{ Auth::user()->settings !== null && Auth::user()->settings->avatar !== null ? Auth::user()->settings->avatar : 'logo-phase2.png' }} </span>
                    <div class="main-menu-layer1">
                        <div class="home-menu animated" @click="homeLoad"></div>                       
                        <div class="insta-menu animated" @click="instagramLoad"></div>
                        <div class="rocket-menu animated" @click="productsLoad('all', 50, false)"></div>                                                                     
                    </div>
                    <el-dialog
                        title="Send Invite"
                        :visible.sync="inviteSend"
                        width="30%">
                            <span>Recipient`s Email</span>
                            <el-input v-model="recEmail"></el-input>

                        <span slot="footer" class="dialog-footer">
                            <el-button @click="inviteSend = false">Cancel</el-button>
                            <el-button type="primary" @click="sendInvite">Send</el-button>
                        </span>
                    </el-dialog>
                    <el-dialog
                        :visible.sync="avatarView"
                        width="30%"
                        class="avatar-view">
                        <img class="avatar-view-preview" style="width: auto;height: auto;" :src="'upload/avatars/' + avatarPreview" />
                    </el-dialog>
                    <div class="main main-navigation-2"  v-loading="loading">
                        <div class="main-navigation-header" v-if="showMenu">
                            <div class="welcome-text">
                                Hello, {{ Auth::user()->name }}!
                            </div>
                            <div class="message">
                                <a href="{{ route('get-logout') }}">
                                    <span class="message-text">
                                        Logout
                                    </span>
                                </a>
                            </div>
                        </div>    
                        <div class="main-navigation-body" v-if="showMenu">
                            <!--<div class="bulletin" @click="bulletinLoad('bulletins' , 50)">-->
                            <div class="bulletin" @click="settingsOpen">
                                <img class="bulletin-image animated" src="{{ asset('img/bulletin-phase2.png') }}" />
                                <span class="bulletin-text">
                                    Settings
                                </span>
                            </div>
                            <div class="creations" @click="imageLoad('creations', 50, false)">
                                <img class="creations-image animated" src="{{ asset('img/creations-phase2.png') }}" />
                                <span class="creations-text">
                                    Creations
                                </span>
                            </div>
                            <div class="favorites" @click="imageLoad('favorites', 50)">
                                <img class="favorites-image animated" src="{{ asset('img/favorites-phase2.png') }}" />
                                <span class="favorites-text">
                                    Favorites
                                </span>
                            </div>
                            <div class="history" @click="imageLoad('histories', 50)">
                                <img class="history-image animated" src="{{ asset('img/history-phase2.png') }}" />
                                <span class="history-text">
                                    History
                                </span>
                            </div>
                        </div>
                        <div class="creations-section" v-if="currentType == 'creations' && showMenu == false">
                            <span class="title">Upload new Badges</span>
                            <div class="progress" id="upload-progress" style="display:none">
                                <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar"
                                 aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                            <div class="row" style="    text-align: center;justify-content: center;display: flex;align-items: center;">
                                <!--<div class="form-group">
                                    <input type="text" class="image-preview" disabled style="font-size: 18px;width: 100%;">
                                    <el-upload
                                        class="upload-demo col-md-2"
                                        style=" margin-right: 6%;"
                                        ref="upload"
                                        action=""
                                        :on-change="prepareCreations"
                                        :auto-upload="false"
                                        :multiple="true"
                                        :file-list="creationsList">
                                    <el-button size="small" type="primary" class="browse-creation">Browse</el-button>
                                </el-upload>
                                </div>
                                <
                                
                                <div class="col-md-1">
                                    <el-button size="small" type="success" @click="uploadCreations">Upload</el-button>
                                </div>-->
                                <div class="input-group image-preview" style="width: 90%">
                                    <input placeholder="" type="text" disabled="disabled" class="form-control image-preview-filename"> 
                                    <span class="input-group-btn"> 
                                        <div class="btn btn-default image-preview-input">
                                            <span class="glyphicon glyphicon-folder-open"></span> 
                                            <span class="image-preview-input-title">Browse</span> 
                                            <input type="file" multiple="multiple" @change="prepareCreations" accept="image/png, image/jpeg, image/gif" name="input-file-preview">
                                        </div> 
                                    </span>
                                </div>
                            </div>
                            <div class="row" style="width: 100%;">
                            <el-select size="small"  v-model="currentUploadCategory" placeholder="Select Category" style="    display: inline-block;
    width: 33%;
    margin-top: 3.1%;">
                                        <el-option
                                        v-for="item in categories"
                                        :label="item.name"
                                        :value="item.id">
                                        </el-option>
                            </el-select>
                            <button type="button" class=" creations-upload-btn  btn btn-labeled btn-primary" @click="uploadCreations(0)" >
                                    <span class="btn-label"><i class="glyphicon glyphicon-upload"></i></span>
                                    Upload
                                </button>
                            </div>
                        </div>
                        <div class="settings-section" v-if="currentSection === 'settings'">
                            <div class="settings-body row">
                                <div>                                
                                    <div class="settings-header">
                                        
                                        <div>
                                            <span class="settings-username js-s-username" v-show="!nameEdit">
                                                {{ Auth::user()->name }}
                                            </span>
                                            <input type="text" class="js-name" value="{{ Auth::user()->name }}" v-show="nameEdit" max="255" style="border: none;font-size: 24px;background: transparent;text-align: center;"/>
                                            <i class="fa fa-pencil" aria-hidden="true" @click="editName" v-if="!nameEdit"></i>       
                                            <i class="fa fa-check-circle-o" aria-hidden="true" @click="saveName" v-else ></i>                                                                       
                                        </div>                    
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12 h-75">
                                            <span class="s-title">Date Joined:</span> 
                                            <span class="s-info">{{ Auth::user()->created_at->format('M d, Y') }}</span> 
                                        </div>
                                        <div class="col-md-12 h-75">
                                            <span class="s-title">Invited by:</span> 
                                            <span class="s-info">{{ Auth::user()->settings !== null && Auth::user()->settings->getInvited() ? Auth::user()->settings->getInvited()->name : 'registered'}}</span> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="width: fit-content;position:relative">
                                            <div class="settings-mask">
                                                <button class="btn btn-default" @click="avatarView = true" style="display: block;margin-bottom: 3%;width:  100%;">View</button>
                                                <button class="btn btn-default" style="display:block;width:  100%;position: relative; overflow: hidden;">
                                                    <span class="pointer"> Change</span>
                                                    <input type="file" class="avatar-input" @change="avatarChange" />
                                                </button>                                        
                                            </div>
                                            <img class="avatar-preview" :src="'upload/avatars/' + avatarPreview" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12 h-75">
                                            <span class="s-title">LDV BALANCE:</span> 
                                            <span class="s-info">0</span> 
                                        </div>
                                        <div class="col-md-12 h-75">
                                            <span class="s-title">LDV EARNED:</span> 
                                            <span class="s-info">0</span> 
                                        </div>
                                        <div class="col-md-12 h-75">
                                            <span class="s-title">INVITES:</span> 
                                            <span class="s-info invites">@{{ userInvites }}</span> 
                                            <div class="d-block w-100 s-info mt-1">
                                                <a @click="inviteSend = true">SEND INVITE</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div class="">
                                            <span class="s-title">Rank:</span> 
                                            <span class="s-info">{{ Auth::user()->settings !== null && Auth::user()->settings->rank_level !== null ? Auth::user()->settings->rank_level : 'Beginner'}}</span> 
                                        </div>
                                    </div>

                                    <!--<div class="col-md-6">
                                        @php 
                                            $birth = Auth::user()->settings !== null ? Auth::user()->settings->age : null;
                                            if ($birth !== null) {
                                                $birth = Carbon\Carbon::createFromFormat('m-d-Y', $birth);
                                            }
                                            $day = $birth !== null ? $birth->format('d') : 1;
                                            $month = $birth !== null ? $birth->format('M') : 'Jan';
                                            $year = $birth !== null ? $birth->format('Y') : '1950';                                        
                                        @endphp
                                        <span class="s-title">Age:</span> 
                                        <span class="s-info js-age" v-show="!ageEdit">{{ $birth !== null ? $birth->age : '...'}}</span> 
                                        <span class="s-edit" v-show="ageEdit">
                                            <select class="form-control js-age-day">
                                                @for($d=1; $d <= 31; $d++)
                                                    <option value="{{ $d }}" {{ $day == $d ? 'selected' : '' }}>{{ $d }}</option>
                                                @endfor
                                            </select>
                                            <select class="form-control js-age-month" >
                                                @for($m=1; $m <= 12; $m++)
                                                    <option value="{{ $m }}" {{ $month == date('M', mktime(0,0,0,$m, 1, date('Y'))) ? 'selected' : '' }}>{{ date('M', mktime(0,0,0,$m, 1, date('Y'))) }}</option>
                                                @endfor
                                            </select>
                                            <select class="form-control js-age-year" >
                                                @for($y=1950; $y <= 2018; $y++)
                                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </span>
                                        <i class="fa fa-pencil" aria-hidden="true" @click="editAge" v-if="!ageEdit"></i>
                                        <i class="fa fa-check-circle-o" aria-hidden="true" @click="saveAge" v-else style="position: absolute;margin-top: 3%;margin-left: 1%;"></i>                                    
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-12">
                                        <span class="s-title">BIO:</span> 
                                        <span class="s-info js-s-bio">{{ Auth::user()->settings !== null && Auth::user()->settings->bio !== null ? str_limit(Auth::user()->settings->bio, 100, '...') : '...'}}</span> 
                                        <i class="fa fa-pencil" aria-hidden="true" @click="editBio"></i>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="store-section" v-if="currentSection == 'products'" style="text-align: center">
                            <div class="store-category" @click="productsLoad('cap', 50, false)">
                                Caps
                            </div>
                            <div class="store-category" @click="productsLoad('t-shirt', 50, false)">
                                T-shirts
                            </div>
                            <div class="store-category" @click="productsLoad('badge', 50, false)">
                                Badges
                            </div>
                            <div class="store-category" @click="productsLoad('book', 50, false)">
                                Books
                            </div>
                        </div>
                        <div class="category-section" v-if="additionalCurrentType == 'category' && showMenu == false">
                            <span class="title">Category Search</span>
                            <div class="select-box">
                                <select id="select-cat" class="category-selecter" name="searchCate" @change="getImages($event.target.value, 50, false, 'category')">
                                    <option value="0">All</option>       
                                    <option :value='category.id' v-for='category in categories'>@{{ category.name }}</option>                             
                                </select>
                            </div>
                        </div>
                        <div class="faq-section" v-if="additionalCurrentType == 'aboutUs' && showMenu == false">
                            <div class="faq-description">
                                <div v-if="currentType === 'faq'">
                                    Freely scroll through the frequently asked questions on our carousel.
                                </div>
                                <div v-if="currentType === 'location'">
                                    Address 12437 Lewis Street Suite 100, Garden Grove CA 92840
                                </div>
                                <div v-if="currentType === 'goals'">
                                </div>
                                <div v-if="currentType === 'team'">
                                    <span class="title">Our best team</span>
                                    <div class="select-box">
                                        <select id="team-cat" class="category-selecter" name="searchCate" @change="bulletinLoad('team', 50, false, 'aboutUs', '/' + $event.target.value)">
                                            <option value="0">All</option>
                                            @foreach(App\Team::TYPES as $type => $value)
                                                <option value="{{ $value }}">{{ $type }}</option>        
                                            @endforeach                     
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-menu">
                                <a @click="bulletinLoad('team', 50, false, 'aboutUs')"> Team </a>
                                <a @click="openLocationCloud"> Location</a>
                                <a @click="bulletinLoad('goals', 50, false, 'aboutUs')"> Goals</a>
                            </div>                            
                        </div>
						<div class="main-menu-layer3" v-if="arrowEnable">
							<div class="left-many animated" @click="spiralManyLeft"><img src="{{ asset('img/left-many-arrow.png') }}"></div>
							<div class="left-single animated" @click="spiralLeft"><img src="{{ asset('img/left-arrow.png') }}"></div>
							<div class="right-single animated" @click="spiralRight"><img src="{{ asset('img/right-arrow.png') }}"></div>
							<div class="right-many animated" @click="spiralManyRight"><img src="{{ asset('img/right-many-arrow.png') }}"></div>  
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
                                <img :class="'js-image-badge ' + image.className" onmousedown='panelImg(event, $(this))' :src='"upload/thumbs/" + image.name'  :data-pos="image.num" :data-id="image.id"  />
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
                <div id="location-cloud" v-if="currentSection === 'location'" >
                    <button type="button" class="btn btn-primary" @click="changeMenuState" v-if="showAllMenu">Hide Navigation </button>
                    <button type="button" class="btn btn-primary" @click="changeMenuState" v-else>Show Navigation</button>                    
                    <gmap-map
                        ref="gmap"
                        :center="center"
                        :zoom="zoom"
                        style="width: 100%; height:100%; "
                        >
                        <gmap-info-window
                                :position="{lat:33.782485,lng:-117.897881}"
                                :opened="infoWinOpen"
                                @closeclick="infoWinOpen=false">
                            <div class="infoContentBox">
                                <strong> Love'M .... Badge'M. </strong>
                            </div>
                        </gmap-info-window>
                        <gmap-marker 
                            :position="{lat:33.782085,lng:-117.897881}"
                            :clickable="true"
                            :icon="{url:'{{ asset('img/logo-phase2.png')}}',  size: {width: 50, height: 50}, scaledSize: {width: 50, height:50} }"
                            :width="50"
                            @click="markerClick"></gmap-marker>
                    </gmap-map>
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
                    <iframe allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen
                        :src="'https://www.youtube.com/embed/' + currentVideoCode">
                    </iframe>
                </div>
            </div>
       </main-page>
    </div>
@endsection

@section('custom-css')
    <style>
        .el-upload-list--text {
            display: none !important;
        }
        .el-upload__input {
            display: none !important;
        }
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
        <link rel="stylesheet" href="/css/images.css">

@endsection