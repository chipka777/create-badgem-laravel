@extends('layouts.app')

@section('content')
    <div id="app">
        <main-page inline-template>
            <div>
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
                        <div class="button-sections">
                            <div id="members-section">
                                <span class="title">MEMBERS</span>
                                @if (Auth::guest())
                                    <form class="form-member-post" method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}
                                    
                                        <div class="member-form">                                   
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="E-MAIL" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="PASSWORD" required>
                                            </div>
                                            <div class="form-group check-box">
                                                <label class="check-label">REMEMBER ME
                                                <input class="member-check"  name="remember" type="checkbox"></label>
                                            </div>
                                        </div>
                                        <div class="member-form-buttons">
                                            <div class="form-group">
                                                <input class="member-submit login-btn" type="button" value="LOGIN" @click="loginUser($event.target.form)">
                                            </div>
                                            <div class="form-group">
                                                <input class="member-submit" type="button" value="REGISTER" @click="showRegister">
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <a href="{{ route('admin') }}"><el-button type="warning" plain>Dashboard</el-button></a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <el-button type="info" plain>Logout</el-button>
                                    </a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                @endif
                            </div>
                            <!--<div id="members-section" class="w_70" >
                                <form class="form-member-post" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <span class="title">MEMBERS</span>
                                    <div class="member-form row">
                                        <img src="{{ asset('img/right-fly.png')}}" class="right-fly" />
                                        <img src="{{ asset('img/left-fly.png')}}" class="left-fly" />                                    
                                        <div class="form-group col-md-6">
                                            <input type="email" name="email" placeholder="E-MAIL" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="password" name="password" placeholder="PASSWORD" required>
                                        </div>
                                        <div class="form-group check-box col-md-12">
                                            <label class="check-label">REMEMBER ME
                                            <input class="member-check" type="checkbox"></label>
                                        </div>
                                    </div>
                                    <div class="member-form-buttons row">
                                        <div class="form-group col-md-12">
                                            <input class="member-submit login-btn" type="submit" value="LOGIN">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="member-submit" type="button" value="REGISTER" @click="showRegister">
                                        </div>
                                    </div>
                                </form>
                            </div>-->
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
                                <!--<span class="title">Category Search</span>

                                <div class="select-box">
                                    <div class="select-side">
                                        <img src="/img/arrow-bg-x.png" />
                                    </div>
                                    <select id="select-cat" class="category-selecter" name="searchCate" @change="getImages($event.target.value, 70, true)">
                                        <option value="0">All</option>
                                        <option :value='category.id' v-for='category in categories'>@{{ category.name }}</option>
                                    </select>
                                </div>-->
                            </div>
                            <div id="register-active-section">
                                <form class="form-member-post" method="POST" action="http://badgem.app/login">
                                    <div class="register-active-wrap">
                                        <div class="member-form">
                                            <span class="title">REGISTRATION CODE</span>
                                            <div class="form-group">
                                                <input type="text" name="code" required>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="member-form-buttons">
                                            <div class="form-group">
                                                <input class="member-submit" type="button" value="NEXT" @click="activateAccount">
                                            </div>
                                        </div>
                                </form>    
                            </div>
                            <div id="register-section" >
                                
                                <span class="title">CREATE ACCOUNT</span>
                                <form class="form-member-post" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}
                                    <div class="reg-form-wrap">
                                        <div class="member-form">
                                            <div class="form-group">
                                                <input type="text" name="first_name" placeholder="FIRST NAME" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="USERNAME" value="" required>
                                            </div>    
                                            <div class="form-group">
                                                <input type="text" name="last_name" placeholder="LAST NAME" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="PASSWORD" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="E-MAIL" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" placeholder="CONFIRM PASS" required>
                                            </div>   
                                        </div>
                                        <a href="#" class="fb-login"><span class="fb-login-text"><img src="img/fb.png" alt="">login with facebook</span></a>
                                    </div>
                                    
                                    <div class="member-form-buttons">
                                        <div class="form-group">
                                            <input class="member-submit" type="button" value="NEXT" @click="registerUser($event.target.form)" >
                                        </div>
                                    </div>
                                </form>
                                <!--<form class="form-member-post" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <span class="title">CREATE ACCOUNT</span>
                                    <div class="member-form row pr0">
                                        <div class="separator"></div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="first_name" placeholder="FIRST NAME" value="{{ old('first_name') }}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="username" placeholder="USERNAME" value="{{ old('username') }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="last_name" placeholder="LAST NAME" value="{{ old('last_name') }}" required>                                     
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="password" name="password" placeholder="PASSWORD" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="email" name="email" placeholder="E-MAIL" value="{{ old('email') }}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="password" name="confitm_password" placeholder="CONFIRM PASSWORD" required>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="member-form-buttons row" style="left:36%;">
                                        <div class="form-group col-md-12">
                                            <input class="member-submit login-btn" type="submit" value="LOGIN" style="opacity: 0">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="member-submit" type="submit" value="NEXT" @click="showRegisterActivate">
                                        </div>
                                    </div>
                                </form>-->
                            </div>
                        </div>

                        <div class="button-nav">
                            <div id="insta-nav" class="menu-item animated" @click="getInstaImages"></div>
                            <div id="bitcoin-nav" class="menu-item animated" @click="getBicoinCash"></div>    
                            <div id="category-nav" class="menu-item animated" @click="showSection('category', -15)"></div>   
                            <div id="members-nav" class="menu-item animated" @click="showSection('members', -40)"></div> 
                        </div>

                        <!--<div class="row button-nav" >
                            <div id="insta-nav" class="col-md-3  spec-nav menu-item" @click="getInstaImages">
                            </div>
                            <div id="bitcoin-nav" class="col-md-3  spec-nav menu-item">
                            </div>    
                            <div id="category-nav" class="col-md-3 spec-nav menu-item">
                            </div>   
                            @if (Auth::guest())
                                <div id="members-nav" class="col-md-3 spec-nav menu-item" @click="showSection('members', -35)"></div> 
                            @else 
                                <a class="spec-nav" href="{{ route('admin') }}"><div id="members-nav" class="col-md-3 spec-nav menu-item"></div> </a>
                            @endif                                                                                                              
                        </div>-->

                        
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
                        <!--<div class="row spiral-nav" >
                            <div class="col-md-2 spl-navig spl-self-nav" @click="spiralLeft">
                                <img src="{{ asset('img/self-left-nav.png') }}" />
                            </div>
                            <div class="col-md-2 spl-navig spl-many-nav" @click="spiralManyLeft">
                                <img src="{{ asset('img/many-left-nav.png') }}" />
                            </div>  
                            <div class="col-md-2 spl-navig spl-self-nav-r" @click="spiralRight">
                                <img src="{{ asset('img/self-right-nav.png') }}" />
                            </div> 
                            <div class="col-md-2 spl-navig spl-many-nav-r" @click="spiralManyRight">
                                <img src="{{ asset('img/many-right-nav.png') }}" />                                
                            </div>
                        </div>-->

                        <div class="drop-me">
                            <p>Drop me Here</p>
                        </div>
                    </div>
                </div>
               
                <!-- <div class="main">
                    <div class="menu-element menu-category file-btn-search"></div>
                    <div class="menu-element menu-left prev" page-value="1" @click="spiralLeft"></div>
                    <div class="menu-element menu-instagram"  @click="getInstaImages"></div>
                    <div class="menu-element menu-members" onclick="showMain('login')"></div>
                    <div class="menu-element menu-right next" page-value="1" @click="spiralRight"></div>
                    <div class="menu-element menu-bitcoin" onclick="showMain('bitcoin')"></div>

                    
                       <div class="menu-center">
                            <div id="menu-text" class="main-text" data-prev='0'>
                                <h2>Welcome!</h2>
                            </div>

                            <div id="drop" class="drop-text" data-prev='0'>
                                <h2>Drop me here!</h2>
                            </div>

                            <div id="cat-search" class="category-search" data-prev='0'>
                                <h3>Category Search !</h3>
                                <select id="select-cat" name="searchCate" @change="getImages($event.target.value)">
                                    <option value="0">Select Category</option>
                                    <option :value='category.id' v-for='category in categories'>@{{ category.name }}</option>
            
                                </select>
                            </div>

                            <div id="login" class="login-menu" data-prev='0'>
                                <h3>Authorization</h3>
                                <input type="email" placeholder="Email">
                                <input type="password" placeholder="Password">
                                <input type="submit" value="Login">
                                @if (!\Auth::user())
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">E-Mail</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @else 
                                <a href="{{ url('dashboard')}}">Dashboard</a>
                                @endif
                            </div>

                            <div id="bitcoin" class="bitcoin-menu" data-prev='0'>
                                <h2>Bitcoin Section</h2>
                            </div>
                        </div>
                   
                </div>--><!-- END MAIN -->
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
