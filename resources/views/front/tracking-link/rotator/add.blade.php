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
                    <strong>Create </strong>({{ $types->name}})
                </div>
                <form method="post" action="{{ route('tracking-links.rotator.store') }}" class="form-horizontal">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-md-12 col-form-label required" for="title">Friendly name</label>
                            <div class="col-md-12">
                                <input type="text" id="hf-email" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Friendly name" value="{{ old('title')}}"> @if ($errors->has('title'))
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
                                <select id="select1_redirect_mode" class="form-control" name="redirect_mode_id" onclick="checkRedirectMode(this)">
                                    @if($redirect_mode) @foreach($redirect_mode as $mode)
                                    <option value="{{$mode->id}}"> {{$mode->name}}</option>
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
                            <div class="destination-Url_bs" id="destination-Url_bs-1">
                                <label class="col-md-3 col-form-label" for="destination">Destination URL 1 <em class="danger">*</em></label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        @if( count($amazLinks) >0)
                                            <select  class="selectpicker form-control dataPicker {{ $errors->has('destination.*') ? ' is-invalid' : '' }}" data-show-subtext="true" data-fv-field="destination[select][]" data-live-search="true" name="destination[select][]">

                                                @foreach($amazLinks as $amazLink)
                                                    @foreach($amazLink->getDestinationUrls as $url)
                                                    <option value="{{$url->destination_url}}" data-subtext="{{URL::to('/'.$url->unique_url)}}">{{$amazLink->title}}</option>
                                                    @endforeach
                                                @endforeach

                                            </select>
                                        @endif
                                        <input type="text" id="input2-group3" name="destination[]" class="form-control destination_input {{ $errors->has('destination.*') ? ' is-invalid' : '' }}" placeholder="" style="{{ count($amazLinks)>0?'display:none':'block'}}">

                                        @if( count($amazLinks) >0)
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:;" onclick="setDestinationUrlAction('amz',1,this)">My amz links</a>
                                                <a class="dropdown-item" href="javascript:;" onclick="setDestinationUrlAction('url',1,this)">URL</a>
                                            </div>
                                        </div>
                                        @endif
                                         @if ($errors->has('destination.*'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('destination.*') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $newUser= count($amazLinks) <=0 ?'new':1; @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <a href="javascript:;" id="addNewDestinationBtn" class="btn btn-outline-primary float-right ml-3" onclick="newDestinationUrl('{{$newUser}}')"><i class="fa fa-plus"></i>Add destination url</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="types" value="{{ $types->id }}"/>
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
                            {!!  Form::select('campaign_id', $campaigns, null, [ 'class'=>'form-control ']) !!}
                            {!! $errors->first('campaign_id', '<span class="invalid-feedback"><strong>:message</strong></span>') !!}
                        </div>
                    </div>
                    </div>
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