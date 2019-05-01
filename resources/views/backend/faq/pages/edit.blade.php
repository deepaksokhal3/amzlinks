<div class="card">
	<div class="card-header">
		<strong>Edit Page</strong>
	</div>
	{!! Form::model($page,['route' => ['page.update',$page->id],'method'=>'PATCH']) !!}
		@include('backend.faq.pages.forms.index')
		<div class="card-footer">
			<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update</button>
		</div>
	{!! Form::close() !!}
</div>
