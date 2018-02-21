@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/profile.css">

@endsection
@section('content')
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
            <div class="panel panel-profile">
                <div class="clearfix " style="display:flex">
                    <!-- LEFT COLUMN -->
                    <div class="profile-left" style="">
            
                        <!-- PROFILE HEADER -->
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <div class="profile-main">
                                <img src="{{ $meta->avatar }}" class="img-circle" alt="Avatar">
                                <h3 class="name">{{ $user->name }}</h3>
                            </div>
                            <div class="profile-stat">
                                <div class="row">
                                    <div class="col-md-4 stat-item">
                                        {{ $meta->image_count }} <span>Images</span>
                                    </div>
                                    <div class="col-md-4 stat-item">
                                        {{ $meta->favorited_count }} <span>In favorites</span>
                                    </div>
                                    <div class="col-md-4 stat-item">
                                        {{ $meta->favorite_add }} <span>Times favorite your image</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE HEADER -->
            
                        <!-- PROFILE DETAIL -->
                        <div class="profile-detail">
                            <div class="profile-info">
                                <h4 class="heading">Basic Info</h4>
                                <ul class="list-unstyled list-justify">
                                    <li>First name <span> {{ ucfirst($meta->first_name) }}</span></li>
                                    <li>Last name <span> {{ ucfirst($meta->last_name) }}</span></li>
                                    <li>Email <span>{{ $user->email }}</span></li>                                
                                    <li>Joined <span> {{ $user->created_at }}</span></li>
                                </ul>
                            </div>
                            <div class="profile-info">
                                <h4 class="heading">Social</h4>
                                <ul class="list-inline social-icons">
                                    @if ($meta->facebook)
                                        <li><a href="{{ $meta->facebook }}" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if ($meta->twitter)                                
                                        <li><a href="{{ $meta->twitter }}" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                                    @endif                                    
                                    @if ($meta->google)
                                        <li><a href="{{ $meta->google }}" class="google-plus-bg"><i class="fa fa-google-plus"></i></a></li>
                                    @endif                                
                                    @if ($meta->linkedin)                                
                                        <li><a href="{{ $meta->linkedin }}" class="linkedin-bg"><i class="fa fa-linkedin-square"></i></a></li>
                                    @endif                                
                                </ul>
                            </div>
                            <div class="profile-info">
                                <h4 class="heading">About</h4>
                                <p>{{ $meta->about }}</p>
                            </div>
                            @role('administrator')
                                <div class="text-center"><a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit Profile</a></div>
                            @elseif(Auth::user()->id == $user->id) 
                                <div class="text-center"><a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a></div>
                            @endrole
                        </div>
                        <!-- END PROFILE DETAIL -->
                    </div>
                    <!-- END LEFT COLUMN -->
            
                    <!-- RIGHT COLUMN -->
                    <div class="profile-right " >
                        <h4 class="heading">{{ ucfirst($meta->first_name) }} {{ ucfirst($meta->last_name) }}</h4>
                        <div class="awards">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="award-item">
                                        <div class="hexagon">
                                            <span class="lnr lnr-sun award-icon"></span>
                                        </div>
                                        <span>Most Bright Idea</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="award-item">
                                        <div class="hexagon">
                                            <span class="lnr lnr-clock award-icon"></span>
                                        </div>
                                        <span>Most On-Time</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="award-item">
                                        <div class="hexagon">
                                            <span class="lnr lnr-magic-wand award-icon"></span>
                                        </div>
                                        <span>Problem Solver</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="award-item">
                                        <div class="hexagon">
                                            <span class="lnr lnr-heart award-icon"></span>
                                        </div>
                                        <span>Most Loved</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><a href="#" class="btn btn-default">See all awards</a></div>
                        </div>
                        <div class="">
                            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                <ul class="nav" role="tablist">
                                    <li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Recent Activity</a></li>
                                </ul>
                            </div>
                            <div class="tab-content history">
                                <history :id="{{ $user->id }}" inline-template>
                                    <div class="tab-pane fade in active" id="tab-bottom-left1">
                                        <ul class="list-unstyled activity-timeline" v-loading="loading">
                                            <li v-for="history in histories" v-html="history.html"></li>
                                        </ul>
                                        <div v-if="count > 5" class="margin-top-30 text-center"><a @click="loadMore" class="btn btn-default">See more activity</a></div>                                    
                                    </div>
                                </history>
                            </div>
                        </div>
                        <!-- END TABBED CONTENT -->
                    </div>
                    <!-- END RIGHT COLUMN -->
                </div>
            </div>
		<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('scripts')
@endsection