@extends('layouts.app')

@section('content')
    <div id="app">
        <main-page inline-template>
            <div>
                <div class="main">
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
                            <!--<h3>Authorization</h3>
                            <input type="email" placeholder="Email">
                            <input type="password" placeholder="Password">
                            <input type="submit" value="Login">-->
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
                </div><!-- END MAIN -->
                <div class="main-canvas">
                    <div class="scale-line">
                        <div class="scale-back">
                            <div id="canvas-line" class="scale-line-front" ondragstart="return false;" >
                                <div id="canvas-scale" onmousedown="canvasScale(event, $(this))" class="scale-btn"></div>
                            </div>
                        </div>
                    </div>
                    <div class="canvas" ondragstart="return false;" onmousedown="hideLatest()"></div>
                    <div class="canvas-btn">
                        <div class="canvas-btn-home" onclick="canvasHide()" ></div>
                        <div class="canvas-btn-scale"></div>
                        <div class="canvas-btn-print" @click="savePNG"></div>
                    </div>
                </div>
                <div class="panels">
                    <div :id='"img-"+image.id' :class='"panel pos"+image.num+" canva-img"' v-for='(image, key) in images' :data-pos="image.num">
                        <img onmousedown='panelImg(event, $(this))' :src='"upload/" + image.name' v-if="!image.insta" :data-pos="image.num"/>
                        <img onmousedown='panelImg(event, $(this))' :src='image.name' v-else :data-pos="image.num"/>
                    </div>
                </div>
            </div>
       </main-page>
    </div>
@endsection
