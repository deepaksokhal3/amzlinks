@extends('layouts.app')

@section('content')

<!-- Main content -->
<main class="main">
	<!-- Breadcrumb -->
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
		<li class="breadcrumb-item active">Create Campaign</li>
		<li class="breadcrumb-menu d-md-down-none">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
			</div>
		</li>
	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-header">
					<strong>Create </strong>
				</div>
				<form  method="post" action="{{ URL::to('campaign/add') }}" class="form-horizontal">
					@csrf
					<div class="card-body">

						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignName">Campaign name</label>
							<div class="col-md-9">
								<input type="text" id="hf-email" name="campaignName" class="form-control {{ $errors->has('campaignName') ? ' is-invalid' : '' }}" placeholder="Campaign name" value="{{ old('campaignName')}}">
								@if ($errors->has('campaignName'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('campaignName') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignNotes">Notes</label>
							<div class="col-md-9">
								<textarea  id="textarea-input"  rows="9" name="campaignNotes" class="form-control  {{ $errors->has('campaignNotes') ? ' is-invalid' : '' }}" placeholder="Notes">{{ old('campaignNotes')}}</textarea>
								@if ($errors->has('campaignNotes'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('campaignNotes') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignTags">Tags</label>
							<div class="col-md-9">
								<input type="text" id="hf-email" name="campaignTags" data-role="tagsinput" class="form-control  {{ $errors->has('campaignTags') ? ' is-invalid' : '' }}" placeholder="Tags" value="{{ old('campaignTags')}}">
								@if ($errors->has('campaignTags'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('campaignTags') }}</strong>
								</span>
								@endif
							</div>
						</div>

					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
						<button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
@endsection