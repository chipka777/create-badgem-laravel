@extends('layouts.app')

@section('content')
    <div id="app">
        <main-page inline-template>
            <div>
                <el-popover
                    popper-class="popover-adorable"
                    ref="upload"
                    placement="top-start"
                    width="140"
                    trigger="hover"
                    content="In this section you can upload your unique designs">
                </el-popover>
                <el-popover
                    popper-class="popover-adorable"
                    ref="logout"
                    placement="right-start"
                    width="70"
                    trigger="hover"
                    content="Logout. Goodbye!">
                </el-popover>
                <div class="main-navigation-wrap">
                    <div class="main main-navigation"  v-loading="loading" @mouseenter="hoverMenu" @mouseleave="unhoverMenu">
                        <span @click="openHome"><img class="menu-home-btn" src="{{ asset('img/top-menu.png') }}"></span>
                        <div class="preloader text-center">
                            <div id="preloader_1">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div> 
                        
                        <div class="head-navigation">
                            <div v-popover:upload class="upload"></div>                            
                            <div v-popover:logout class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </div>
                        </div>
                        <div class="button-sections">
                            <div id="bitcoin-section" class="col-md-4" >
                                <p><span class="title">Bitcoin</span></p>
                                <p>
                                Last -  <span v-if="bitcoinData">@{{ Math.round(parseFloat(bitcoinData.last) * 100) / 100 }}$</span>
                                </p>
                                <p>
                                Bid -  <span v-if="bitcoinData">@{{ Math.round(parseFloat(bitcoinData.bid) * 100) / 100 }}$</span>
                                </p>
                                <p>
                                High -  <span v-if="bitcoinData">@{{ Math.round(parseFloat(bitcoinData.high) * 100) / 100 }}$</span>
                                </p>

                            </div>
                            <div id="category-section" >
                                <span class="title">Category Search</span>
                                <div class="select-box">
                                    <select id="select-cat" class="category-selecter" name="searchCate" @change="getImages($event.target.value, 70, true)">
                                        <option value="0">All</option>
                                        @if (Auth::user())
                                            <option value="favorited">Favorited</option>   
                                        @endif                                     
                                        <option :value='category.id' v-for='category in categories'>@{{ category.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="button-nav">
                            <div id="insta-nav" class="menu-item animated" @click="getInstaImages"></div>
                            <div id="bitcoin-nav" class="menu-item animated" @click="getBicoinCash"></div>    
                            <div id="category-nav" class="menu-item animated" @click="showSection('category', -15)"></div>   
                        </div>
                        
                        <div class="spiral-nav">
                            <div class="spl-nav-left">
                                <div class="spl-navig spl-self-nav" @click="spiralLeft">
                                    <img src="img/self-left-nav.png" />
                                </div>
                                <div class="spl-navig spl-many-nav" @click="spiralManyLeft">
                                    <img src="img/many-left-nav.png" />
                                </div>  
                            </div>
                            <div class="spl-nav-right">
                                <div class="spl-navig spl-many-nav-r" @click="spiralManyRight">
                                    <img src="img/many-right-nav.png" />                          
                                </div>
                                <div class="spl-navig spl-self-nav-r" @click="spiralRight">
                                    <img src="img/self-right-nav.png" />
                                </div> 
                            </div>  
                        </div>
                
                        <div class="drop-me">
                            <p>Drop me Here</p>
                        </div>
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
                    <div :id='"img-"+image.id' :class='"panel pos"+image.num+" canva-img"' v-for='(image, key) in images' :data-pos="image.num" >
                        <img onmousedown='panelImg(event, $(this))' :src='"upload/thumbs/" + image.name' v-if="!image.insta" :data-pos="image.num" @mouseenter="showToolTip($event, key)" @mouseleave="hideToolTip($event, key)" />
                        <img class="insta-img" onmousedown='panelImg(event, $(this))' :src='image.name' v-else :data-pos="image.num" />
                    </div>
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
