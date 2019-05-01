<div class="card-body">
    <div class="form-group">
        {!! Form::label('title','Friendly name', ['class' => 'col-md-12 col-form-label required']) !!}
        <div class="col-md-12">
            {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''),'placeholder'=>'Friendly name']) !!} {!! $errors->first('title', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
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
                    {!! Form::select('marketplace', $countries, null, ['class'=>'selectpicker form-control '.($errors->has('marketplace') ? ' is-invalid' : '')],$flags) !!} {!! $errors->first('marketplace', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @if(isset($types) && $types->id !=2 || isset($link->types) && $link->types !=2)
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    {!! Form::label('keywordfile','Import (csv,txt)', ['class' => 'col-md-3 col-form-label opt-0']) !!}
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="upload-btn-wrapper">
                            <button class="btn-upload">Import (csv,txt)</button>
                            {{ Form::file('keywordfile',['class'=>'readKeywordfile']) }}
                        </div>
                        <span  class="error invalid-feedback" style="display:block"><strong>Max 800 keywords can be imported</strong></span>
                        <span id="keywordfile-error" class="error invalid-feedback" style="display:none"></span>
                    </div>
                    <div class="col-md-6">
                        <div class="attachment">
                            <span class="badge badge-danger">csv</span> <b>sample</b> <i>(75kb)</i>
                            <span class="menu">
                                  <a href="{{asset('files/sample.csv')}}" download="sample.csv" class="fa fa-cloud-download"></a>
                                </span>
                        </div>
                        <div class="attachment">
                            <span class="badge badge-danger">txt</span> <b>sample</b> <i>(27kb)</i>
                            <span class="menu">
                                  <a href="{{asset('files/sample.txt')}}" download="sample.txt" class="fa fa-cloud-download"></a>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        @if(!isset($link->id))
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('asin[]','Asin', ['class' => 'col-md-12 col-form-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('asin[]', null, ['class' => 'form-control' . ($errors->has('asin.*') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!} {!! $errors->first('asin.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @else @php $asin = (Array)json_decode($link->asin, true);@endphp
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('asin[]','Asin', ['class' => 'col-md-12 col-form-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('asin[]', $asin[0], ['class' => 'form-control' . ($errors->has('asin.*') ? ' is-invalid' : ''),'placeholder'=>'Asin']) !!} {!! $errors->first('asin.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @endif @if(isset($types) && $types->id !=2 || isset($link->types) && $link->types !=2 || count(Request::old('keyword')) > 1)
        <div class="col-md-6" id="mode-type" style="display:{{ isset($link) && count($link->getDestinationUrls) > 1 || count(Request::old('keyword')) > 1? 'block':'none' }}">
            <div class="form-group">
                {!! Form::label('redirect_mode_id','Redirect mode', ['class' => 'col-md-3 col-form-label required']) !!}
                <div class="col-md-12">
                    {!! Form::select('redirect_mode_id', $redirect_mode, null, ['id'=>'changemode','class'=>'form-control '.($errors->has('redirect_mode_id') ? ' is-invalid' : '')]) !!} {!! $errors->first('redirect_mode_id', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col" id="keywrd-card-body">
        @if(!isset($link->id)) @if(Request::old('keyword')) @foreach(Request::old('keyword') as $key => $keyword )
        <div class="row" id="keywrd-row-{{$key}}">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('keyword[]', null, ['class' => 'form-control' . ($errors->has('keyword.'.$key) ? ' is-invalid' : ''),'placeholder'=>'Keyword']) !!} @if(Request::old('percentage')) {!! Form::text('percentage[]', null, ['class' => 'form-control col-md-3' . ($errors->has('percentage.'.$key) ? ' is-invalid' : ''),'placeholder'=>'%']) !!} @endif {!! $errors->first('keyword.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span> ') !!} {!! $errors->first('percentage.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span> ') !!}
                    </div>
                </div>
            </div>
            @if($key !=0)
            <i class="fa fa-trash rm-fild-asin-row" index="keywrd-row-{{$key}}" style="float: right; position: absolute; margin-top:0.7%; color:#f63c3a; cursor: pointer;"></i> @endif
        </div>

        @endforeach @else
        <div class="row" id="keywrd-row-0">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('keyword[]', null, ['class' => 'form-control' . ($errors->has('keyword.*') ? ' is-invalid' : ''),'placeholder'=>'Keyword']) !!} {!! $errors->first('keyword.*', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                    </div>
                </div>
            </div>
        </div>
        @endif @else @php $keywords = (Array)json_decode($link->keyword,true); @endphp @foreach($keywords as $key=>$keyword)
        <div class="row" id="keywrd-row-{{$key}}">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('keyword[]', $keyword, ['class' => 'form-control' . ($errors->has('keyword.'.$key) ? ' is-invalid' : ''),'placeholder'=>'Keyword']) !!} {!! $errors->first('keyword.'.$key, '<span class="invalid-feedback"><strong>:message</strong></span>') !!} @if($link-> redirect_mode_id == 2 && count($link->getDestinationUrls) > 1) {!! Form::text('percentage[]', $link->getDestinationUrls[$key]->percentage, ['class' => 'form-control col-md-3 percentage-2step' . ($errors->has('percentage.'.$key) ? ' is-invalid' : ''),'placeholder'=>'%']) !!} @endif
                    </div>
                </div>
            </div>
            @if($key !=0)
            <i class="fa fa-trash rm-fild-asin-row" index="keywrd-row-{{$key}}" style="float: right; position: absolute; margin-top:0.7%; color:#f63c3a; cursor: pointer;"></i> @endif
        </div>
        @endforeach @endif
    </div>

    <div class="row">
        @if(isset($types) && $types->id ==2 || isset($link->types) && $link->types ==2)
        <div class="col-md-12">
            {!! Form::label('intermediate_page','Show intermediate page with instructions', ['class' => 'col-md-6 col-form-label required']) !!}
            <div class="col-md-6">
                <label class="switch switch-icon switch-pill switch-success-outline">
                    {!! Form::checkbox('intermediate_page', 'on', null,['class' => 'switch-input']) !!}
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>
            </div>
        </div>
        @endif @if(isset($types) && $types->id !=2 || isset($link->types) && $link->types !=2)
        <div class="col-md-12">
            <div class="form-group">
                <div class="float-right">
                    <a href="javascript:;" id="add-field-asin" class="btn btn-outline-primary float-right ml-3" on=""><i class="fa fa-plus"></i>Add New</a>
                </div>
            </div>
        </div>
        @endif
    </div>
    {!! Form::hidden('types', isset($types)?$types->id:$link->types) !!}
    <hr class="m-0">
    <div class="form-group">
        {!! Form::label('pixelcodes','Tracking Codes', ['class' => 'col-md-3 col-form-label']) !!}
        <div class="col-md-6">
            {!! Form::select('pixelcodes[]', $trackingCodes, $SelectedPixelCodes, [ 'class'=>'selectpicker form-control'.($errors->has('pixelcodes') ? ' is-invalid' : ''),'multiple' => true],$option) !!} {!! $errors->first('pixelcodes', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('campaign_id','Campaign', ['class' => 'col-md-3 col-form-label']) !!}
        <div class="col-md-6">
            {!! Form::select('campaign_id', $campaigns, null, [ 'class'=>'form-control '.($errors->has('campaign_id') ? ' is-invalid' : '')]) !!} {!! $errors->first('campaign_id', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
        </div>
    </div>
</div>