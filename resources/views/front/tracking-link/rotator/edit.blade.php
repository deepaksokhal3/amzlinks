@extends('layouts.app') @section('content')

<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Create Tracking Link</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <strong>Edit </strong> ({{$link->getUrlType->name}})
                </div>
                <form method="post" action="{{ route('tracking-links.update') }}" class="form-horizontal">
                    @csrf
                    <div class="card-body">
                        <input id="rmLnkIds" type="hidden" name="rmLinkIds" >
                        <div class="form-group">
                            <label class="col-md-12 col-form-label required" for="title">Friendly name</label>
                            <div class="col-md-12">
                                <input type="text" id="hf-email" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Friendly name" value="{{$link->title}}"> @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row">
                            <label class="col-md-12 col-form-label"> Configure your tracking link</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-form-label" for="redirect_mode_id">Redirect mode <em>*</em></label>
                            <div class="col-md-12">
                                <select id="select1_redirect_mode" class="form-control" name="redirect_mode_id" alt="edit" onclick="checkRedirectMode(this)">
                                    @if($redirect_mode) @foreach($redirect_mode as $mode)
                                    <option value="{{$mode->id}}" {{$link->redirect_mode_id == $mode->id? 'selected' :''}}> {{$mode->name}}</option>
                                    @endforeach @endif
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong>The percentage must be equal to 100%. </strong>
                                </span>

                                @if ($errors->has('redirect_mode_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('redirect_mode_id') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        <div class="form-group" id="destination-url-container">
                            @if(count($link->getDestinationUrls) > 0)
                                @foreach($link->getDestinationUrls as $key=>$destinationUrl)
                                <div class="destination-Url_bs" id="destination-Url_bs-{{$key +1 }}">
                                    <label class="col-md-3 col-form-label" for="destination">Destination URL {{$key +1 }} <em class="danger">*</em></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            @if( isset($amazLinks) && count($amazLinks) >0 && $destinationUrl->type =='YES')
                                                <select class="selectpicker form-control dataPicker" data-show-subtext="true" data-fv-field="destination[{{$destinationUrl->id}}]" data-live-search="true" name="destination[{{$destinationUrl->id}}]">
                                                    @foreach($amazLinks as $amazLink)
                                                        @foreach($amazLink->getDestinationUrls as $url)
                                                        <option value="{{$url->destination_url}}" data-subtext="{{URL::to('/'.$url->unique_url)}}">{{$amazLink->title}}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                                @elseif($key ==0)
                                                 <select class="selectpicker form-control dataPicker" data-show-subtext="true" data-fv-field="destination[select][]" data-live-search="true" name="destination[]" id="hidn-drop">
                                                    @foreach($amazLinks as $amazLink)
                                                        @foreach($amazLink->getDestinationUrls as $url)
                                                        <option value="{{$url->destination_url}}" data-subtext="{{URL::to('/'.$url->unique_url)}}">{{$amazLink->title}}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            @endif
                                            @if($destinationUrl->type =='NO')
                                                <input type="text" id="input2-group3" name="destination[{{$destinationUrl->id}}]" class="form-control destination_input" placeholder="" value="{{$destinationUrl->destination_url}}" index="{{$destinationUrl->id}}">
                                            @else
                                                <input type="text" id="input2-group3" style="display: none;" name="destination[]" class="form-control destination_input" index="{{$destinationUrl->id}}" placeholder="" value="" index="">
                                            @endif
                                            @if($link->redirectMode->name == 'Weighted')
                                            <input type="text"  maxlength="3" name="percentage[{{$destinationUrl->id}}]" class="form-control col-md-3 percentage_input" value="{{$destinationUrl->percentage}}" placeholder="%">
                                            @endif

                                            @if ($errors->has('destination'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('destination') }}</strong>
                                            </span>
                                            @endif
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                     <a class="dropdown-item" href="javascript:;" rm-data="{{$destinationUrl->id}}" onclick="setDestinationUrlAction('amz','{{$key +1}}',this)">My amz links</a>
                                                <a class="dropdown-item" href="javascript:;" rm-data="{{$destinationUrl->id}}" onclick="setDestinationUrlAction('url','{{$key +1}}',this)">URL</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($key !=0)
                                    <i class="fa fa-trash"  rm-data="{{$destinationUrl->id}}" onclick="rmDestinationUrl(this)" style="float: right; position: absolute; margin-top: -23px; color:#f63c3a; cursor: pointer;"></i>
                                    @endif
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <a href="javascript:;" class="btn btn-outline-primary float-right ml-3" onclick="newDestinationUrl('edit')"><i class="fa fa-plus"></i>Add destination url</a>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="types" value="{{ $link->types }}"/>
                        <hr class="m-0">
                        <div class="row">
                            <label class="col-md-12 col-form-label"> Configure your tracking link</label>
                        </div>
                        <div class="form-group">
                           <input type="text"  class="form-control" placeholder="Friendly name" value="{{URL::to('/'.$link->uniqe_url)}}" readonly>
                       </div>
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
                            {!!  Form::select('campaign_id', $campaigns, null, [ 'class'=>'form-control ']) !!}
                            {!! $errors->first('campaign_id', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$link->id}}">
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

@endsection