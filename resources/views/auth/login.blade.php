@extends('layouts.app')

@section('content')
<div id="app" v-cloak>
    <login-page inline-template :user="{{ session('user') ? 'true' : 'false' }}" :error="'{{ session()->get('error') }}'">
        <div class="main-navigation-wrap login-page">
            <div class="main main-navigation"  v-loading="loading" element-loading-spinner="icon-loading" v-if="showPage">
                <div id="members-section" v-if="currentSection == 'login'">
                    <span class="title">HELLO, welcome to Badge`m </br> Would you like to?</span>
                    <form class="form-member-post" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="member-form-buttons" style="display: inline-block">
                            <div class="form-group">
                                <input class="member-submit login-btn" type="button" value="LOGIN" @click="login">
                            </div>
                            <div class="form-group">
                                <input class="member-submit" type="button" value="REGISTER" @click="activeUser ? currentSection = 'activate' : currentSection = 'register'">
                            </div>
                        </div>
                        <div class="member-form-buttons" style="display: inline-block">
                            <div class="form-group">
                                <a href="#" @click="openWindow('/login/facebook/')" style="text-decoration: none"><input class="member-submit facebook-btn" type="button" value="FACEBOOK" style="background-color: #6eb9ea;color: white;"></a>
                            </div>
                            <div class="form-group">
                                <a href="#" @click="openWindow('/login/google/')" style="text-decoration: none"><input class="member-submit google-btn" type="button" value="GOOGLE" style="background-color: #ea736e;color: white;"></a>
                            </div>
                        </div>
                        <div class="member-form">                                   
                            <div class="form-group">
                                <input type="email" v-model="loginForm.email" name="email" placeholder="E-MAIL" value="" required>
                            </div>
                            
                            <div class="form-group">
                                <input type="password" v-model="loginForm.password" name="password" placeholder="PASSWORD" required>
                            </div>
                            <div class="form-group check-box">
                                <label class="check-label remember-btn">REMEMBER ME
                                <input class="member-check" v-model="loginForm.remember"  name="remember" type="checkbox"></label>
                                <a class="forgotten-btn"  @click="currentSection = 'forgotten'">Forgot password?</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="register-section" v-if="currentSection == 'register'"> 
                    <span class="title text-center reg-title">CREATE ACCOUNT</span>
                    <form class="form-member-post" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="reg-form-wrap">
                            <div class="member-form">
                                <!--<div class="form-group">
                                    <input type="text" v-model="registerForm.first_name" name="first_name" placeholder="FIRST NAME" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="registerForm.name" name="name" placeholder="USERNAME" value="" required>
                                </div> 
                                <div class="form-group">
                                    <input type="text" v-model="registerForm.last_name" name="last_name" placeholder="LAST NAME" value="" required>
                                </div>   -->
                                <div class="form-group">
                                    <input type="email" v-model="registerForm.email" name="email" placeholder="E-MAIL" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="registerForm.confirm_email" name="confirm_email" placeholder="Confirm E-MAIL" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="registerForm.password" name="password" placeholder="PASSWORD" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="registerForm.password_confirmation" name="password_confirmation" placeholder="CONFIRM PASS" required>
                                </div>   
                                <div class="form-group" style="flex-basis: 100%;">
                                    <input type="text" v-model="registerForm.invite_code" style="text-align: center;" name="invite_code" placeholder="INVITE CODE" value="" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="member-form-buttons ">
                            <div class="form-group">
                                <input class="member-submit back-btn" type="button" value="Back" @click="currentSection = 'login'" >
                            </div>
                            <div class="form-group">
                                <input class="member-submit" type="button" value="NEXT" @click="register">
                            </div>
                        </div>
                    </form>
                </div>
                <div id="register-active-section" v-if="currentSection == 'activate'">
                    <form class="form-member-post" method="POST" action="">
                        <div class="register-active-wrap">
                            <div class="member-form">
                                <span class="title">REGISTRATION CODE</span>
                                <div class="form-group">
                                    <input type="text" v-model="activateForm.code" name="code" required>
                                </div>
                            </div>
                        </div> 
                        <div class="member-form-buttons">
                                <div class="form-group" v-if="activeUser">
                                    <input class="member-submit back-btn" type="button" value="Back" @click="currentSection = 'login'" >
                                </div>
                                <div class="form-group">
                                    <input class="member-submit" type="button" value="NEXT" @click="activate">
                                </div>
                            </div>
                    </form>    
                </div>
                <div id="register-active-section" v-if="currentSection == 'forgotten'">
                    <form class="form-member-post" method="POST" action="">
                        <div class="register-active-wrap">
                            <div class="member-form">
                                <span class="title">Enter your E-mail</span>
                                <div class="form-group">
                                    <input type="email" v-model="forgottenForm.email" name="email" required>
                                </div>
                            </div>
                        </div> 
                        <div class="member-form-buttons">
                                <div class="form-group">
                                    <input class="member-submit back-btn" type="button" value="Back" @click="currentSection = 'login'" >
                                </div>
                                <div class="form-group">
                                    <input class="member-submit" type="button" value="Send" @click="forgottenPassword">
                                </div>
                            </div>
                    </form>   
                </div>
            </div>
            <div class="main-loader" v-loading="loading" element-loading-spinner="icon-loading" v-else style="width:300px"></div>
        </div>
    </login-page>
</div>
@endsection
