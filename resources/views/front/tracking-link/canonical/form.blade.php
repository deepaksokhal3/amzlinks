
<div class="card-body">
    <div class="form-group">
        {!! Form::label('title','Friendly name', ['class' => 'col-md-12 col-form-label required']) !!}
        <div class="col-md-12">
            {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''),'placeholder'=>'Friendly name']) !!}
            {!! $errors->first('title', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
        </div>
    </div>
   <hr class="m-0">
    <div class="row">
          {!! Form::label('','Configure your tracking link', ['class' => 'col-md-12 col-form-label']) !!}
    </div>
      <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    {!! Form::label('marketplace','Marketplace', ['class' => 'col-md-3 col-form-label required']) !!}
                <div class="col-md-12">
                    {!!  Form::select('marketplace', $countries, null, ['class'=>'selectpicker form-control '.($errors->has('marketplace') ? ' is-invalid' : '')],$flags) !!}
                    {!! $errors->first('marketplace', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
    </div>
   <div class="card-body" id="main-buy-together">
        @if(!isset($link->id))
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword[1]', null, ['class' => 'form-control' . ($errors->has('keyword.1') ? ' is-invalid' : ''),'placeholder'=>'Keyword 1']) !!}
                    {!! $errors->first('keyword.1', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword[2]', null, ['class' => 'form-control' . ($errors->has('keyword.2') ? ' is-invalid' : ''),'placeholder'=>'Keyword 2']) !!}
                    {!! $errors->first('keyword.2', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword[3]', null, ['class' => 'form-control' . ($errors->has('keyword.3') ? ' is-invalid' : ''),'placeholder'=>'Keyword 3']) !!}
                    {!! $errors->first('keyword.3', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword[4]', null, ['class' => 'form-control' . ($errors->has('keyword.4') ? ' is-invalid' : ''),'placeholder'=>'Keyword 4']) !!}
                    {!! $errors->first('keyword.4', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword[5]', null, ['class' => 'form-control' . ($errors->has('keyword.5') ? ' is-invalid' : ''),'placeholder'=>'Keyword 5']) !!}
                    {!! $errors->first('keyword.5', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('asin[1]', null, ['class' => 'form-control' . ($errors->has('asin.*') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!}
                    {!! $errors->first('asin.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @else
        @php
            $asin = (Array)json_decode($link->asin,true);
         @endphp
        @foreach(json_decode($link->keyword) as $key=>$item)
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('keyword['.$key.']', $item, ['class' => 'form-control' . ($errors->has('keyword.'.$key) ? ' is-invalid' : ''),'placeholder'=>'Keyword '.$key]) !!}
                    {!! $errors->first('keyword.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('asin[1]', $asin[1], ['class' => 'form-control' . ($errors->has('asin.1') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!}
                    {!! $errors->first('asin.1', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @endif
           <div class="form-group">
         {!! Form::label('intermediate_page','Show intermediate page with instructions', ['class' => 'col-md-3 col-form-label required']) !!}
            <div class="col-md-6">
                 <label class="switch switch-icon switch-pill switch-success-outline">
                    {!! Form::checkbox('intermediate_page', 'on', null,['class' => 'switch-input']) !!}
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>
            </div>
        </div>
    </div>
    @if(isset($types))
      {!! Form::hidden('types', $types->id) !!}
      @endif
    <hr class="m-0">
    <div class="form-group">
            {!! Form::label('pixelcodes','Tracking Codes', ['class' => 'col-md-3 col-form-label']) !!}
        <div class="col-md-6">
            {!!  Form::select('pixelcodes[]', $trackingCodes, $SelectedPixelCodes, [ 'class'=>'selectpicker form-control','multiple' => true],$option) !!}
            {!! $errors->first('pixelcodes', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
        </div>
    </div>
    <div class="form-group">
            {!! Form::label('campaign_id','Campaign', ['class' => 'col-md-3 col-form-label']) !!}
        <div class="col-md-6">
            {!!  Form::select('campaign_id', $campaigns, null, [ 'class'=>'form-control']) !!}
            {!! $errors->first('campaign_id', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
        </div>
    </div>
</div>