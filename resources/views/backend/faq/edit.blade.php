<div class="card">
	<div class="card-header">
		<strong>Edit Catagory</strong>
	</div>
	{!! Form::model($faqCatagory,['route' => ['faq.update',$faqCatagory->id],'method'=>'PATCH']) !!}
		@include('backend.faq.forms.index')
		<div class="card-footer">
			<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update</button>
		</div>
	{!! Form::close() !!}
</div>