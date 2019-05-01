`
@extends('layouts.app')

@section('content')

<!-- Main content -->
<main class="main">
	<!-- Breadcrumb -->
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
		<li class="breadcrumb-item active">Profile</li>
		<li class="breadcrumb-menu d-md-down-none">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
			</div>
		</li>
	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<!---------Profile section ---------->
				<div class="col-sm-8">
					<div class="card">
						<div class="card-header">
							<strong>Profile </strong>
						</div>
						<form  method="post" action="{{ route('profile.update') }}" class="form-horizontal">
							@csrf
							<div class="card-body">

								<div class="form-group">
									<label for="name">Full name <em>*</em></label>
									<input type="text" id="hf-email" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full name" value="{{$user->name}}">
									@if ($errors->has('name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
									@endif
								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label for="country">Country <em>*</em></label>
										<select class="form-control  {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country_id">
											<option value="">-Select Country-</option>
											@if(count($countries) >0)
											@foreach($countries as $country)
											<option value="{{$country->code}}" {{ $country->code == $user->country_id?'selected':''}}> {{$country->country_name}}</option>
											@endforeach
											@endif
										</select>
										@if ($errors->has('country'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('country') }}</strong>
										</span>
										@endif
									</div>
								</div>

							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update Profile</button>
							</div>
						</form>
					</div>
					<!---------End Profile section ---------->
				</div>

				<!---------Profile upload pic section ---------->
				<div class="col-sm-4">
					<div class="card">
						<div class="card-header">
							<strong>Profile Image</strong>
						</div>
						<div class="card-body text-center">
							<form method="post" action="{{ route('profile.upload')}}" enctype="multipart/form-data">
								@csrf
								@if ($errors->has('profilePic'))
								<div class="alert alert-danger text-left">
									{{ $errors->first('profilePic') }}
								</div>
								@endif
								@if ($message = Session::get('success'))
								<div class="alert alert-success alert-block text-left">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>{{ $message }}</strong>
								</div>
								@endif
								<input type="hidden" name="action" value="avatar">
								<div class="row align-items-center mb-3">
									<div class="col-md-6">
										<div class="flex-center">
											@if(Auth::user()->image)
											<img src="{{asset('images/'.Auth::user()->image)}}"/ height="100" width="100">
											@else
											<i class="fa fa-image fa-4x grey-text text-lighten-2"></i>
											@endif
										</div>
									</div>
									<div class="col-md-6">

										<div>Maximum size of 2000k JPG, GIF, PNG.</div>
									</div>
								</div>
								<div class="form-group">
									<label class="sr-only" for="avatar">Example file input</label>
									<input type="file" class="form-control-file "  name="profilePic">
								</div>
								<button class="btn btn-primary btn-block" type="submit">Upload</button>
							</form>
						</div>
					</div>
					<!---------End Profile upload pic section ---------->
					<!-- <div class="card">
						<div class="card-header">
							<i class="fa fa-at"></i> Email address
						</div>
						<div class="card-body">
							<p>Manage your email address. Be sure your email address is working, we will send you notifications from users, renewals.</p>
							<a class="btn btn-primary btn-block" href="" title="Manage email address">
							Manage email address</a>
						</div>
					</div> -->

					<div class="card">
						<div class="card-header">
							<i class="fa fa-lock"></i> Password
						</div>
						<div class="card-body">
							<p>Manage your password. We highly recommend to update your password regularly for security reasons.</p>
							<a class="btn btn-primary btn-block" href="{{URL::to('/change-password')}}" title="Manage password">
							Manage password</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection