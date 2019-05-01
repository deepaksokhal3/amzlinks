@extends('layouts.app')
@section('content')
<!-- Main content -->
<main class="main">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> <a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">

        <div class="animated fadeIn">
        <div class="card">
            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class') }}" role="alert">
                    <h4 class="alert-heading">Current Plan Status!</h4>
                    <hr>
                    <p>{{ Session::get('message') }} <a href="{{ URL::to('/subscription')}}">Here</a>.</p>
                </div>
            @endif
            <div class="card-body">

          <div class="row">
                    <div class="col-sm-12 col-lg-12">
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="callout callout-secondary">
                            <small class="text-muted">Total Campaigns</small>
                            <br>
                            <strong class="h4">{{ $totlaCamp}} Campaigns</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-4">
                          <div class="callout callout-success">
                            <small class="text-muted">Tracking Links</small>
                            <br>
                            <strong class="h4">{{ count($links)}} Links</strong>
                            <div class="chart-wrapper">
                            </div>
                          </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-4">
                          <div class="callout callout-primary">
                            <small class="text-muted">Total Clicks</small>
                            <br>
                            <strong class="h4">{{ isset($allCliks[0])?$allCliks[0]:0}} Clicks</strong>
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
                </div>
              </div>
              <input type="hidden" id="analyticResults" value="{{ json_encode($analytics)}}"/>
            <div class="card-columns cols-2">
                <div class="card">
                    <div class="card-header">
                        Total vs Unique
                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper" id="canvas-1">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Clicks by Browsers
                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper" id="browser-chart">
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        Clicks by Platforms
                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper" id="canvas-5">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Top-Cities
                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper" id="canvas-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.conainer-fluid -->
</main>
@endsection