
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
                    {!!  Form::select('marketplace', $countries, null, ['class'=>'selectpicker form-control '.($errors->has('marketplace') ? ' is-invalid' : '')]) !!}
                    {!! $errors->first('marketplace', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
    </div>
   <div class="card-body" id="main-buy-together">
       <div class="row">
         @if(!isset($link->id))
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('asin[]', null, ['class' => 'form-control' . ($errors->has('asin.*') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!}
                    {!! $errors->first('asin.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('quentity[]', null, ['class' => 'form-control' . ($errors->has('quentity.*') ? ' is-invalid' : ''),'placeholder'=>'Quentity']) !!}
                    {!! $errors->first('quentity.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            @else
        @php
            $asin =  (Array)json_decode($link->asin, true);
            $quantity = (Array)json_decode($link->quantity,true);
        @endphp
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('asin[]', $asin[0], ['class' => 'form-control' . ($errors->has('asin.*') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!}
                    {!! $errors->first('asin.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('quentity[]', $quantity[0], ['class' => 'form-control' . ($errors->has('quentity.*') ? ' is-invalid' : ''),'placeholder'=>'Quentity']) !!}
                    {!! $errors->first('quentity.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        @endif
        </div>
    </div>
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