@extends('layouts.app')

@section('content')
<!-- Main content -->
<main class="main">
	<!-- Breadcrumb -->
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
		<li class="breadcrumb-item active">Update Campaign</li>
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
				<form  method="post" action="{{ URL::to('campaign/update') }}" class="form-horizontal">
					@csrf
					<div class="card-body">

						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignName">Campaign name</label>
							<div class="col-md-9">
								<input type="text" id="hf-email" name="campaignName" class="form-control" value="{{$campaign->campaignName}}" placeholder="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignNotes">Notes</label>
							<div class="col-md-9">
								<textarea  id="textarea-input"  rows="9" name="campaignNotes" class="form-control"  placeholder="Notes">{{$campaign->campaignNotes}}</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="campaignTags">Tags</label>
							<div class="col-md-9">
								<input type="text" id="hf-email" name="campaignTags" class="form-control" data-role="tagsinput"  value="{{$campaign->campaignTags}}" placeholder="">
							</div>
						</div>
						<input type="hidden" id="hf-email" name="id" class="form-control" value="{{$campaign->id}}" placeholder="">
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update</button>
						<button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
@endsection