<div class="card-body">
	<div class="form-group row">
		{!! Form::label('name','Catagory Name', ['class' => 'col-md-3 col-form-label']) !!}
		<div class="col-md-9">
		{!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
		{!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
		</div>
	</div>
</div>
