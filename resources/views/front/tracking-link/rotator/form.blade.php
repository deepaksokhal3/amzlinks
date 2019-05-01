 <div class="card-body">
    <div class="form-group">
        <label class="col-md-12 col-form-label" for="title">Friendly name <em>*</em></label>
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
                        <select id="select-url1" class="selectpicker form-control dataPicker" data-show-subtext="true" data-fv-field="destination[select][]" data-live-search="true" name="destination[select][]">

                            @foreach($amazLinks as $amazLink)
                                @foreach($amazLink->getDestinationUrls as $url)
                                <option value="{{$url->destination_url}}" data-subtext="{{URL::to('/'.$url->unique_url)}}">{{$amazLink->title}}</option>
                                @endforeach
                            @endforeach

                        </select>
                    @endif
                    <input type="text" id="input2-group3" name="destination[]" class="form-control destination_input" placeholder="" style="{{ count($amazLinks)>0?'display:none':'block'}}">
                    @if ($errors->has('destination'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('destination') }}</strong>
                    </span>
                    @endif
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
    <input type="hidden" name="types" value="{{ $url_type }}"/>
    <hr class="m-0">
    <div class="form-group">
        <label class="col-md-3 col-form-label" for="tracking_code_id">Tracking Codes</label>
        <div class="col-md-6">
            <select id="select1" class="selectpicker form-control" name="pixelcodes[]" multiple>
                @if( count($trackingCodes) >0) @foreach($trackingCodes as $trackingCode)
                <option value="{{$trackingCode->id}}" data-icon="{{$trackingCode->trackingType->icon}}"> {{$trackingCode->trackingType->name}}</option>
                @endforeach @endif
            </select>
            @if ($errors->has('pixelcodes'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('pixelcodes') }}</strong>
            </span> @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 col-form-label" for="campaign_id">Campaign</label>
        <div class="col-md-6">
            <select id="select1" class="selectpicker form-control" name="campaign_id">
                @if(count($campaigns) > 0)
                @foreach($campaigns as $campaign)
                <option value="{{$campaign->id}}"> {{$campaign->campaignName}}</option>
                @endforeach @endif
            </select>
            @if ($errors->has('campaign_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('campaign_id') }}</strong>
            </span> @endif
        </div>
    </div>
</div>