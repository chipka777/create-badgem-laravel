@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/profile.css">

@endsection
@section('content')
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
            <div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Change Password</h3>
				</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <i class="fa fa-times-circle"></i> {{ $errors->first() }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif
                            <form action="{{ route('profile.change-password.post') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="cur_password"> Current Password</label>
                                    <input type="password" id="cur_password" class="form-control" placeholder="Current Password" name="cur_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password"> New Password</label>
                                    <input type="password" id="password" class="form-control" placeholder="New Password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password"> Confirm New Password</label>
                                    <input type="password" id="new_password" class="form-control" placeholder="Confirm New Password" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('scripts')
@endsection