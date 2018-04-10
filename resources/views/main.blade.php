@extends('layouts.app')

@section('content')
    <div id="app">
        <main-page inline-template>
            <div>
                <div class="main-navigation-wrap" >
                    <div class="main-menu-layer1">
                        <div class="home-menu animated" @click="homeLoad"></div>                       
                        <div class="insta-menu animated"></div>
                        <div class="rocket-menu animated"></div>                                                                     
                    </div>
                    <div class="main main-navigation-2"  v-loading="loading">
                        <div class="row main-navigation-header">
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
                        <div class="row main-navigation-body">
                            <div class="row">
                                <div class="col-md-6 bulletin" @click="bulletinLoad">
                                    <img class="col-md-4 bulletin-image animated" src="{{ asset('img/bulletin-phase2.png') }}" />
                                    <span class="bulletin-text col-md-6">
                                        Bulletin
                                    </span>
                                </div>
                                <div class="col-md-6 creations  pull-right" @click="creationsLoad(50)">
                                    <img class="col-md-4 creations-image animated" src="{{ asset('img/creations-phase2.png') }}" />
                                    <span class="creations-text col-md-6">
                                        Creations
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 favorites" @click="favoritesLoad(50)">
                                    <img class="col-md-4 favorites-image animated" src="{{ asset('img/favorites-phase2.png') }}" />
                                    <span class="favorites-text col-md-6">
                                        Favorites
                                    </span>
                                </div>
                                <div class="col-md-6 history"  @click="historiesLoad(50)">
                                    <img class="col-md-4 history-image animated" src="{{ asset('img/history-phase2.png') }}" />
                                    <span class="history-text col-md-6">
                                        History
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="drop-me">
                            <p>Drop me Here</p>
                        </div>
                    </div>
                    <div class="main-menu-layer2">
                        <div class="diamond-menu animated"></div>
                        <div class="paint-menu animated"></div>       
                        <div class="zoom-menu animated"></div>                                                                 
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
                            <div class="image-wrap">
                                <img onmousedown='panelImg(event, $(this))' :src='"upload/thumbs/" + image.name' v-if="!image.insta" :data-pos="image.num" :data-id="image.id" @mouseenter="showToolTip($event, key)" @mouseleave="hideToolTip($event, key)" />
                                <img class="insta-img" onmousedown='panelImg(event, $(this))' :src='image.name' v-else :data-pos="image.num" :data-id="image.id" />
                                <i class="fa fa-heart favorite-heart"></i>    
                            </div>   
                        </div>
                    </template>
                    <template v-if="currentSection === 'bulletins'">
                        <div :id='"img-"+key' :class='"panel pos"+key+" cloud-img"' v-for='(bulletin, key) in bulletins' :data-pos="key"  :data-id="key">
                            <span>@{{ bulletin }}</span>
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
            </div>
       </main-page>
    </div>
@endsection
