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
					<h3 class="panel-title">Become a Designer</h3>
				</div>
				<div class="panel-body">
						
					<div class="row" style="text-align:center;font-size:27px">
						
						<form action="{{ route('become-designer') }}" method="POST">
							{{ csrf_field() }}
							
								@if (session('error'))
									<div class="col-md-8 col-md-offset-2">	
										<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
											<i class="fa fa-times-circle"></i> {{ session('error') }}
										</div>
									</div>
								@endif
								
							<div class="input-group col-md-8 col-md-offset-2" style="padding: 65px;">
								
								<input class="form-control" type="text" name="invite_code" placeholder="Enter a special code">
								<span class="input-group-btn"><button class="btn btn-primary" type="submit">Go!</button></span>
							</div>
						</form>
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