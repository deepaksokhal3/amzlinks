
@extends('layouts.admin')
@section('content')
 <!-- Main content -->
    <main class="main">

 	<ol class="breadcrumb">
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

         <hr class="m-0">
                <div class="col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="callout callout-secondary">
                                <small class="text-muted">Total Users</small>
                                <br>
                                <strong class="h4">{{$totalUser}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-4">
                            <div class="callout callout-success">
                                <small class="text-muted">Total Campaigns</small>
                                <br>
                                <strong class="h4">{{ $totalCampaign}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-4">
                            <div class="callout callout-primary">
                                <small class="text-muted">Total Tracking Links</small>
                                <br>
                                <strong class="h4">{{$totalLinks}}</strong>
                                <div class="chart-wrapper">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--/.row-->
                    <hr class="mt-0">

                </div>
                <input type="hidden" id="dahResults" value="{{ json_encode($analytic)}}">
                    <div class="card-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">Users vs New Users</h4>
                            </div>
                        </div>
                        <!--/.row-->
                        <div class="chart-wrapper" style="margin-top:0px;">
                            <div id="user-vs-newusers" class="chart"></div>
                        </div>
                    </div>
                </div>
                <!--/.card-->
      </div>
      <!-- /.conainer-fluid -->
    </div>
  </div>
</main>
@endsection