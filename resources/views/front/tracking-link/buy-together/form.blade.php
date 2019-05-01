
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
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('asin[1]', null, ['class' => 'form-control' . ($errors->has('asin.1') ? ' is-invalid' : ''),'placeholder'=>'Asin 1']) !!}
                    {!! $errors->first('asin.1', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('quentity[1]', null, ['class' => 'form-control' . ($errors->has('quentity.1') ? ' is-invalid' : ''),'placeholder'=>'Quentity 1']) !!}
                    {!! $errors->first('quentity.1', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        <div class="row" id="init-row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('asin[2]', null, ['class' => 'form-control' . ($errors->has('asin.2') ? ' is-invalid' : ''),'placeholder'=>'Asin 2']) !!}
                    {!! $errors->first('asin.2', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('quentity[2]', null, ['class' => 'form-control' . ($errors->has('quentity.2') ? ' is-invalid' : ''),'placeholder'=>'Quentity 2']) !!}
                    {!! $errors->first('quentity.2', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @else
        @php
            $qty = (Array)json_decode($link->quantity,true);
         @endphp
        @foreach(json_decode($link->asin) as $key=>$item)
         <div class="row" id="init-row{{$key !=1?$key:''}}">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('asin['.$key.']', $item, ['class' => 'form-control' . ($errors->has('asin.'.$key) ? ' is-invalid' : ''),'placeholder'=>'Asin 1']) !!}
                    {!! $errors->first('asin.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('quentity['.$key.']', $qty[$key], ['class' => 'form-control' . ($errors->has('quentity.'.$key) ? ' is-invalid' : ''),'placeholder'=>'Quentity 1']) !!}
                    {!! $errors->first('quentity.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
             <div class="form-group">
                <div class="float-right">
                    <a href="javascript:;" id="add-buy-together" class="btn btn-outline-primary float-right ml-3" on><i class="fa fa-plus"></i>Add New</a>
                </div>
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