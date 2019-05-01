<div class="card-body">
	<div class="row">
		<div class="col-sm-6 form-group">
			{!! Form::label('title','Title') !!}
			{!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}

		</div>
		<div class="col-sm-6 form-group">
			{!! Form::label('cat_id','Select Catagory') !!}
			{!! Form::select('cat_id', $catagories, null, ['placeholder' => 'select catagory','class'=>'form-control'. ($errors->has('cat_id') ? ' is-invalid' : '')]) !!}
			{!! $errors->first('cat_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}

		</div>
	</div>
	<div class="row">
		{!! Form::label('description','Page Content', ['class' => 'col-md-3 col-form-label']) !!}
		<div class="form-group col-sm-12">

			{!! Form::textarea('description',null, [ 'class'=>'form-control faq-text-editer'. ($errors->has('description') ? ' is-invalid' : '')])  !!}
			{!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
		</div>
	</div>
</div>
