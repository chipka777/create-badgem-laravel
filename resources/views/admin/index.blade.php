@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">

@endsection
@section('content')
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Admin Dashboard</h3>
				</div>
				<div class="panel-body">
						@if (session('activate_invite'))
							<div class="row">
								<div class="col-md-8 col-md-offset-2">	
									<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
										<i class="fa fa-check-circle"></i> {{ session('activate_invite') }}
									</div>
								</div>
							</div>
						@endif
					<div class="row" style="text-align:center;font-size:27px">
						<!--<div class="col-md-offset-3 col-md-3">
							<a href="{{ route('images.index') }}">
								<div class="mgmt-btn">
									Images Managment
								</div>
							</a>
						</div>
						<div class="col-md-3">
							<a href="{{ route('categories.index') }}">
							<div class="mgmt-btn">
								Categories Managment
							</div>
							</a>
						</div>-->
						Welcome to Badgem Dashboard!
					</div>
				</div>
			</div>
		<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('scripts')
@endsection