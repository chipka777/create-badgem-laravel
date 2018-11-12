<!doctype html>
<html lang="en">

<head>
	<title>Dashboard | Badgem</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="/assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
	
        
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="/assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="/assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	@yield('css')
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon.png">
</head>

<body>
	<div id="app" v-cloak>
		<!-- WRAPPER -->
		<div id="wrapper">
			<!-- NAVBAR -->
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="brand">
					<a href="{{ route('main') }}"><img src="/assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
				</div>
				<div class="container-fluid">
					<div class="navbar-btn">
						<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
					</div>
					<form class="navbar-form navbar-left">
						<div class="input-group">
							<input type="text" value="" class="form-control" placeholder="Search dashboard...">
							<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
						</div>
					</form>

					<div id="navbar-menu">
						<ul class="nav navbar-nav navbar-right">
							<notification inline-template>
								<li class="dropdown" v-cloak>
									<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown" @click="setNotificationAsRead">
										<i class="lnr lnr-alarm" ></i>
										<span v-if='count > 0'  class="badge bg-danger" >@{{ count }}</span>
									</a>
									<ul class="dropdown-menu notifications">
										<li v-for="n in notifications"><a href="#" class="notification-item"><span :class="'dot bg-' + n.status"></span>@{{ n.content }}</a></li>
										<li v-if='notifications.length == 0'><a class="noHave">There are no new notifications</a></li>
										<li><a href="#" class="more">See all notifications</a></li>
									</ul>
								</li>
							</notification>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
									<li><a href="#">Basic Use</a></li>
									<li><a href="#">Working With Data</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ Auth::user()->meta->avatar }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
									@role(['designer', 'administrator'])
									<li><a href="{{ route('profile') }}"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
									@endrole
									<li><a href="{{ route('change-password') }}"><i class="fa fa-user-secret"></i> <span>Change Password</span></a></li>								
									<!--<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>-->
									<li>
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Logout</span></a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- END NAVBAR -->
			<!-- LEFT SIDEBAR -->
			<div id="sidebar-nav" class="sidebar">
				<div class="sidebar-scroll">
					<nav>
						<ul class="nav">
							<li><a href="{{ url('dashboard') }}" class="{{ ($page == 'dashboard') ? 'active' : null }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
								<li>
									<a href="#subPages" class="collapsed {{ ($page == 'images') ? 'active' : null }}" data-toggle="collapse" aria-expanded= "false"><i class="lnr lnr-picture"></i> <span>Images</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
									<div id="subPages" class="collapse ">
										<ul class="nav">
											<li><a href="{{ route('images.showAll') }}" class="">All images</a>
										@permission('read-upload')
											<li><a href="{{ route('images.create') }}" class="">Add new images</a></li>
											<li><a href="{{ route('images.index') }}" class="">Edit existing images</a></li>
										@endpermission
										@role('administrator')
											<li><a href="{{ route('images.pending') }}" class="">Pending images</a></li>
										@endrole
										</ul>
									</div>
								</li>
								@role(['administrator','designer'])
									<li><a href="{{ url('dashboard/categories') }}" class="{{ ($page == 'categories') ? 'active' : null }}"><i class="lnr lnr-list"></i> <span>Categories</span></a></li>
								@endrole

							@permission('read-favorite')
								<li><a href="{{ url('dashboard/favorites') }}" class="{{ ($page == 'favorite') ? 'active' : null }}"><i class="fa fa-heart" aria-hidden="true"></i><span>Favorite images</span></a></li>
							@endpermission

							@role('administrator')
								<li>
									<a href="{{ route('bulletin.index') }}" class="{{ ($page == 'bulletins') ? 'active' : null }}">
										<i class="fa fa-address-card-o" aria-hidden="true"></i>
										<span>Bulletins</span>
									</a>
								</li>
							@endrole

							@role('administrator')
								<li>
									<a href="#products" class="collapsed {{ ($page == 'products') ? 'active' : null }}" data-toggle="collapse" aria-expanded= "false">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<span>Products</span>
										<i class="icon-submenu lnr lnr-chevron-left"></i>
									</a>
									<div id="products" class="collapse ">
										<ul class="nav">
											<li><a href="{{ route('products.cap.index') }}" class="{{ ($page == 'products') ? 'active' : null }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Products</span></a></li>																										
										</ul>
									</div>
								</li>
							@endrole

							@role('administrator')
								<li>
									<a href="{{ route('videos.index') }}" class="{{ ($page == 'videos') ? 'active' : null }}">
										<i class="fa fa-youtube" aria-hidden="true"></i>
										<span>Videos</span>
									</a>
								</li>

							@endrole

							@role('administrator')
								<li><a href="{{ url('dashboard/users') }}" class="{{ ($page == 'users') ? 'active' : null }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Users</span></a></li>						
								<li>
									<a href="#aboutPages" class="collapsed {{ ($page == 'about') ? 'active' : null }}" data-toggle="collapse" aria-expanded= "false">
										<i class="fa fa-book" aria-hidden="true"></i>
											<span>About Us</span>
										<i class="icon-submenu lnr lnr-chevron-left"></i>
									</a>
									<div id="aboutPages" class="collapse ">
										<ul class="nav">
											<li><a href="{{ route('team.index') }}" class="{{ ($page == 'team') ? 'active' : null }}"><i class="fa fa-users" aria-hidden="true"></i><span>Team</span></a></li>																										
											<li><a href="{{ route('goals.index') }}" class="{{ ($page == 'goal') ? 'active' : null }}"><i class="fa fa-star" aria-hidden="true"></i><span>Goals</span></a></li>																																					
											<li><a href="{{ route('faq.index') }}" class="{{ ($page == 'faq') ? 'active' : null }}"><i class="fa fa-question-circle" aria-hidden="true"></i><span>FAQ</span></a></li>						
										</ul>
									</div>
								</li>
							@endrole

							@role('consumer')
								<li><a href="{{ url('dashboard/become-designer') }}" class="{{ ($page == 'become-designer') ? 'active' : null }}"><i class="fa fa-pied-piper" aria-hidden="true"></i> <span>Become a designer</span></a></li>						
							@endrole						
						</ul>
					</nav>
				</div>
			</div>
			<!-- END LEFT SIDEBAR -->
			<!-- MAIN -->
			<div class="main">
				@yield('content')
				<div class="clearfix"></div>
				<footer>
					<div class="container-fluid">
						<p class="copyright">&copy; 2018 <a href="{{ route('main') }}" target="_blank">Badgem</a>. All Rights Reserved.</p>
					</div>
				</footer>
			</div>
		</div>
	</div>
			
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="/assets/vendor/jquery/jquery.min.js"></script>
	<script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="/assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="/assets/scripts/klorofil-common.js"></script>
	<script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')

</body>

</html>
