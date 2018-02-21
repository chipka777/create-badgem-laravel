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
					<h3 class="panel-title">Edit Profile</h3>
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
                        @role('administrator')
                            <form action="{{ route('users.edit.post', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">                        
                        @else
                            <form action="{{ route('profile.edit.post') }}" method="POST" enctype="multipart/form-data">
                        @endrole
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="username"> Username</label>
                                    <input type="text" id="username" class="form-control" placeholder="Username" name="name" value="{{ old('name') ? old('name') : $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email"> Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="first_name"> First name</label>
                                    <input type="text" id="first_name" class="form-control" placeholder="First name" name="first_name" value="{{ old('first_name') ? old('first_name') : $meta->first_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name"> Last name</label>
                                    <input type="text" id="last_name" class="form-control" placeholder="Last name" name="last_name" value="{{ old('last_name') ? old('last_name') : $meta->last_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="facebook"> Facebook</label>
                                    <input type="text" id="facebook" class="form-control" placeholder="Facebook" name="facebook" value="{{ old('facebook') ? old('facebook') : $meta->facebook }}">
                                </div>
                                <div class="form-group">
                                    <label for="twitter"> Twitter</label>
                                    <input type="text" id="twitter" class="form-control" placeholder="Twitter" name="twitter" value="{{ old('twitter') ? old('twitter') : $meta->twitter }}">
                                </div>
                                <div class="form-group">
                                    <label for="google"> Google</label>
                                    <input type="text" id="google" class="form-control" placeholder="Google" name="google" value="{{ old('google') ? old('google') : $meta->google }}">
                                </div>
                                <div class="form-group">
                                    <label for="linkedin"> Linkedin</label>
                                    <input type="text" id="linkedin" class="form-control" placeholder="Linkedin" name="linkedin" value="{{ old('linkedin') ? old('linkedin') : $meta->linkedin }}">
                                </div>
                                <div class="form-group">
                                    <label for="about"> About</label>
                                    <textarea id="about" name="about" class="form-control" placeholder="About" rows="4">{{ old('about') ? old('about') : $meta->about }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="avatar"> Avatar</label>
                                    <input type="file" id="avatar" class="form-control" name="avatar">
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