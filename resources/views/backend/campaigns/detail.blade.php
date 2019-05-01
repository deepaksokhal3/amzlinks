@extends('layouts.admin')
@section('content')
<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/admin')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{URL::to('/admin/users')}}">Manage Users</a></li>
        <li class="breadcrumb-item active">Campaigns</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="#"><i class="icon-speech"></i></a>
                <a class="btn" href="{{URL::to('/admin')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
            </div>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Campaigns
                </div>
                <hr class="m-0">
                <div class="col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="callout callout-secondary">
                                <small class="text-muted">Total Campaigns</small>
                                <br>
                                <strong class="h4">{{$campaigns->total()}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-3">
                            <div class="callout callout-success">
                                <small class="text-muted">Total Tracking Links</small>
                                <br>
                                <strong class="h4">{{ count($links)}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-3">
                            <div class="callout callout-primary">
                                <small class="text-muted">Total Clicks</small>
                                <br>
                                <strong class="h4">{{ isset($allCliks[0])? $allCliks[0]:0}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-3">
                            <div class="callout callout-warning">
                                <small class="text-muted">Total Unique Clicks</small>
                                <br>
                                <strong class="h4">{{isset($allCliks[1])? $allCliks[1]:0}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
                    <!--/.row-->
                    <hr class="mt-0">

                </div>

                <input type="hidden" id="analyticResults" value="{{ json_encode($clicks)}}">
                <div class="card-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">Total Vs Unique Clicks</h4>
                            </div>
                        </div>
                        <!--/.row-->
                        <div class="chart-wrapper" style="margin-top:0px;">
                            <div id="total-vs-unique-clicks" class="chart"></div>
                        </div>
                    </div>
                </div>
                <!--/.card-->
                <!--/.col-->
                <div class="card-body">
                    <table class="table table-responsive-sm table-hover table-outline mb-0">
                        @if(count($campaigns)>0)
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Active</th>
                                <th>Campaigns</th>
                                <th>Total Clicks</th>
                                <th>Unique Clicks</th>
                                <th>Total Links</th>
                                <th class="text-center">Composition</th>
                                <th class="text-center"><i class="icon-settings"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($campaigns as $key => $campaign) @php $totalClickCounter = 0; $uniqueClickCounter = 0; $composition = 0; @endphp @if(count($campaign->countTakingLinks)>0) @if(isset($clicks->rows)) @foreach($clicks->rows as $click) @foreach($campaign->countTakingLinks as $trackLinks) @if($trackLinks->uniqe_url == (str_replace('/', '', $click[1]))) @php $totalClickCounter = $totalClickCounter + $click[2]; $uniqueClickCounter = $uniqueClickCounter + $click[3]; @endphp @endif @endforeach @endforeach @endif @endif @php try{ $composition = ($uniqueClickCounter/$totalClickCounter)*100; }catch(Exception $e){ } @endphp
                            <tr>
                                <td class="text-center">
                                    <div class="avatar">
                                        <span class="avatar-status badge-success"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>{{$campaign->campaignName}}</div>
                                    <div class="small text-muted">
                                        Created: {{$campaign->created_at->format('M d, Y h:i a')}}
                                    </div>
                                </td>
                                <td>
                                    {{$totalClickCounter}}
                                </td>
                                <td>
                                    {{$uniqueClickCounter}}
                                </td>
                                <td>
                                    {{count($campaign->countTakingLinks)}}
                                </td>
                                <td class="text-center composition-grp-sec" rel="{{round($composition)}}">
                                    <div class="gaugejs-wrap sparkline" style="width:34px;height:34px">
                                        <canvas id="gauge-{{$key}}" width="34" height="34"></canvas>
                                        <span class="value">{{ round($composition) }}%</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="{{URL::to('/admin/campaigns/single/'.$campaign->id)}}">
                                        <i class="fa fa-eye "></i></td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                        @if(count($campaigns)<1)
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Active</th>
                                <th>Tracking Link</th>
                                <th>Total Clicks</th>
                                <th>Unique Clicks</th>
                                <th class="text-center">Composition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $key=>$link)
                                @php
                                    $totlaClick = 0;
                                    $uniqueClick = 0;
                                    $composition = 0
                                @endphp
                            @if(isset($clicks->rows))
                                @foreach($clicks->rows as $click)
                                    @if($link->uniqe_url == (str_replace('/', '', $click[1])))
                                        @php $totlaClick = $click[2] +$totlaClick;
                                            $uniqueClick = $click[3] +$uniqueClick;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            @php
                             $composition = $totlaClick >0 ? ($uniqueClick/$totlaClick)*100:0;
                             @endphp
                            <tr>
                                <td class="text-center">
                                    <div class="avatar">
                                        <span class="avatar-status badge-success"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>{{URL::to('/'.$link->uniqe_url)}}</div>
                                    <div class="small text-muted">
                                        Created: {{$link->created_at->format('M d, Y h:i a')}}
                                    </div>
                                </td>
                                <td>
                                    {{$totlaClick}}
                                </td>
                                <td>
                                    {{$uniqueClick}}
                                </td>
                                <td class="text-center composition-grp-sec" rel="{{round($composition)}}">
                                    <div class="gaugejs-wrap sparkline" style="width:34px;height:34px">
                                        <canvas id="gauge-{{$key}}" width="34" height="34"></canvas>
                                        <span class="value">{{ round($composition) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
                {{ $campaigns->links()}}
            </div>
        </div>
    </div>
</main>
@endsection