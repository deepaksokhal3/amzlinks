<div class="card">
	<div class="card-header">
		<strong>Create Page</strong>
	</div>
	{!! Form::open(['route' => 'page.store']) !!}
		@include('backend.faq.pages.forms.index')
		<div class="card-footer">
			<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
		</div>
	{!! Form::close() !!}
</div>
