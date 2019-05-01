<div class="card-body">
	<div class="form-group row">
		 {!! Form::label('trackTitle','Name', ['class' => 'col-md-2 col-form-label']) !!}
		<div class="col-md-4">
	  	{!! Form::text('trackTitle', null, ['class' => 'form-control' . ($errors->has('trackTitle') ? ' is-invalid' : ''),'placeholder'=>'Tracking Name']) !!}
		{!! $errors->first('trackTitle', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
		</div>
	</div>
	<div class="form-group row">
		{!! Form::label('type','Type of code', ['class' => 'col-md-2 col-form-label']) !!}
		<div class="col-md-4">
	   {!!  Form::select('type', $typeOfCodes, null, ['class'=>'selectpicker form-control '.($errors->has('type') ? ' is-invalid' : ''), 'onclick'=>'socialSelectScriptType(this)'],$icons) !!}
		{!! $errors->first('type', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
		</div>
		<div class="col-md-6 d-sm-down-none">
			<p>Example:</p>
		</div>
	</div>
	<div class="form-group row">
		{!! Form::label('trackCode','Code', ['class' => 'col-md-2 col-form-label']) !!}
		<div class="col-md-4">
			 {!!  Form::textarea('trackCode', null, ['class'=>'form-control '.($errors->has('trackCode') ? ' is-invalid' : ''), 'rows'=>'9' ,'placeholder'=>'Insert a entire script or a pixel that will be "fired" once the link is clicked.Example: <script></script> or <img src="http://yourimage.png" />.Must be a valid HTML code.'],$icons) !!}
			 {!! $errors->first('trackCode', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
		</div>
		<div class="col-md-6 d-sm-down-none">
			<img src="/img/social-script/pixel_1.png" id="pixel_example" class="border p-1 img-fluid">
		</div>
	</div>
</div>
