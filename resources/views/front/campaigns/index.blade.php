@extends('layouts.app')

@section('content')
<!-- Main content -->
<main class="main">
  <!-- Breadcrumb -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
    <li class="breadcrumb-item active">Campaigns</li>
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
        <i class="fa fa-align-justify"></i> Campaigns
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-striped">
          <thead>
            <tr>
              <th>Campaign name</th>
              <th>Tracking Links</th>
              <th>Clicks</th>
              <th>Creation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if(count($campaigns) > 0)
              @foreach($campaigns as $campaign)
              @php
              $clickCounter = 0;
              @endphp
              @if(count($campaign->countTakingLinks)>0)
                  @if(isset($clicks->rows))
                    @foreach($clicks->rows as $click)
                      @foreach($campaign->countTakingLinks as $trackLinks)
                          @if($trackLinks->uniqe_url == (str_replace('/', '', $click[0])))
                              @php
                               $clickCounter = $clickCounter + $click[1];
                              @endphp
                          @endif
                        @endforeach
                    @endforeach
                  @endif
                @endif

              <tr id="camp-row-{{$campaign->id}}">
                <td>
                  <h5> <a href="#" data-toggle="tooltip" data-placement="top" class="camp-title"  title="" data-original-title="Show links">{{$campaign->campaignName}} </a></h5>
                  <span class="small text-muted camp-note">{{$campaign->campaignNotes}}</span>
                  <span class="badge badge-primary">{{$campaign->campaignTags}}</span>

                </td>
                <td>{{count($campaign->countTakingLinks)}}</td>
                <td>{{$clickCounter}}</td>
                <td> <span class="small text-muted" >{{ date('Y M, d h:i:a', strtotime($campaign->created_at))}}</span></td>
                <td>
                  <a href="{{URL::to('/campaigns/'.$campaign->id)}}"  class="btn btn-sm btn-dark"> <i class="fa fa-eye"></i></a>
                  <a href="{{ URL::to('campaign/edit') }}" onclick="event.preventDefault(); document.getElementById('camp-form-{{$campaign->id}}').submit();" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                  <a href="javascript:;" class="btn btn-sm btn-danger" onclick="campainDelete({{$campaign->id}})" ><i class="fa fa-trash"></i></a>
                  <form id="camp-form-{{$campaign->id}}" action="{{ URL::to('campaign/edit') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="id" value="{{$campaign->id}}">
                  </form>

                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <a href="{{ URL::to('campaign/add')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Create Campaign</a>
      </div>
    </div>
  </div>
</div>
</main>
@endsection