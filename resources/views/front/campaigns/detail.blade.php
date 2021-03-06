@extends('layouts.app')

@section('content')
   <!-- Main content -->
    <main class="main">
       <!-- Breadcrumb -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
         <li class="breadcrumb-item"><a href="{{URL::to('/campaigns')}}">My Campaigns</a></li>
        <li class="breadcrumb-item active">Detail</li>
        <li class="breadcrumb-menu d-md-down-none">
          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
          </div>
        </li>
      </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-5">
                      <h3 class="card-title clearfix mb-0">{{ucfirst($campaign->campaignName)}}</h3>
                    </div>
                    <div class="col-sm-7">

                      <fieldset class="form-group float-right" >
                        <div class="float-right" style="width:240px;">
                         <a href="{{ URL::to('campaign/add')}}" class="btn btn-outline-primary float-right ml-3"><i class="fa fa-plus"></i> &nbsp; Add Campaign</a>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="row">
                    <div class="col-sm-12 col-lg-12">
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="callout callout-secondary">
                            <small class="text-muted">Total Tracking Links</small>
                            <br>
                            <strong class="h4">{{ count($links)}}</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-3">
                          <div class="callout callout-success">
                            <small class="text-muted">Total Clicks</small>
                            <br>
                            <strong class="h4">{{ isset($allCliks[0])?$allCliks[0]:0}}</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-3">
                          <div class="callout callout-primary">
                            <small class="text-muted">Total Unique Clicks</small>
                            <br>
                            <strong class="h4">{{ isset($allCliks[1])?$allCliks[1]:0}}</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                         <div class="col-sm-3">
                          <div class="callout callout-warning">
                            <small class="text-muted">Total Non Unique Clicks</small>
                            <br>
                            <strong class="h4">{{ isset($allCliks[1])?$allCliks[0]-$allCliks[1]:0}}</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                      </div>
                      <!--/.row-->
                      <hr class="mt-0">

                    </div>
                    <!--/.col-->
                  </div>
                  <br>
                  <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center">Active</th>
                        <th>Tracking Link</th>
                        <th class="text-center">Total Clicks</th>
                        <th>Composition</th>
                        <th class="text-center">Unique Clicks</th>
                        <th>Creation</th>
                        <th class="text-center"><i class="icon-settings"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($links) > 0)

                      @foreach($links as $key=>$link)
                      @php
                        $totlaClick = 0;
                        $uniqueClick = 0;
                        $composition = 0
                      @endphp
                       @if(isset($clicks->rows))
                        @foreach($clicks->rows as $click)
                          @if($link->uniqe_url == (str_replace('/', '', $click[0])))
                              @php
                               $totlaClick = $click[1];
                               $uniqueClick = $click[2];
                               $composition = ($uniqueClick/$totlaClick)*100;
                              @endphp
                          @endif
                        @endforeach
                      @endif
                      <tr>
                        <td class="text-center">
                          <div class="avatar">
                            <span class="avatar-status badge-success"></span>
                          </div>
                        </td>
                        <td>
                          <div>{{$link->title}}</div>
                          <div class="small text-muted">
                           <span  class="encriptUrl">
                            <span class="tooltiptext">Link copied to clipboard</span>
                           <span id="copy-ut-{{$key}}"> {{URL::to('/'.$link->uniqe_url)}}</span></span> <a href="#"><i class="fa fa-copy"  style="font-size:15px; color: #20a8d8;" onclick="copyUrl('copy-ut-{{$key}}')"></i></a>

                          </div>
                          <span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="Link type">{{$link->getUrlType->name}}</span>
                        </td>
                        <td class="text-center">
                          {{$totlaClick}}
                        </td>
                        <td class="text-center">
                          <div class="clearfix">
                            <div class="float-left">
                              <strong>{{round($composition)}}%</strong>
                            </div>
                            <div class="float-right">
                              <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                            </div>
                          </div>
                          <div class="progress progress-xs">
                            <div class="progress-bar bg-{{$composition < 60? 'warning':'success'}}" role="progressbar" style="width: {{$composition}}%" aria-valuenow="{{$composition}}" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </td>
                        <td class="text-center">
                         {{$uniqueClick}}
                        </td>
                        <td>
                           <small class="text-muted">{{$link->created_at}}</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ URL::to('tracking-links/edit') }}" onclick="event.preventDefault(); document.getElementById('links-cmp-{{$link->id}}').submit();" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>

                            <form id="links-cmp-{{$link->id}}" action="{{ route('tracking-links.edit') }}" method="POST" style="display: none;">
                              @csrf
                              <input type="hidden" name="id" value="{{$link->id}}">
                            </form>

                        </td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/.col-->
          </div>

           </div>
      </div>
  </main>
    @endsection