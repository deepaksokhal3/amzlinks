@extends('layouts.app')
@section('content')
<!-- Main content -->
<main class="main">
  <style>

  </style>
  <!-- Breadcrumb -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{URL::to('/campaigns')}}">Campaigns</a></li>
    <li class="breadcrumb-item active">Select Tracking Link</li>
    <li class="breadcrumb-menu d-md-down-none">
      <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn select-track-links-pg">
      <div class="row select-card select-links-sec-m">
        @foreach($types as $key => $type)
        @if($key !=1)
        <div class="col-sm-6 col-lg-3 wow zoomIn {{ in_array($key, [0,2,3,4,5])?'':'show-disabled'}}">
          <a href="{{ URL::to(in_array($key, [0,2,3,4,5])?'tracking-links/'.$type->code:'#')}}" class="text-center btn-trlink btn-1 w-100 selector-url">
            <div class="card">
              <div class="card-body">
                <div class="h4 m-0"><img src="{{asset('/img/icons/'.$type->icon)}}" ></div>
                <div>{{$type->name}}</div>
                @if(in_array($key, [0,2,3,4,5]))
                <small class="text-muted">{{ $type->description}}</small>
                @else
                <h3>Coming Soon</h3>
                @endif
              </div>
            </div>
          </a>
        </div>
        @endif
        @endforeach
        <div class="col-sm-6 col-lg-3 wow zoomIn show-disabled">
          <a href="#" class="text-center btn-trlink btn-1 w-100 selector-url">
            <div class="card">
              <div class="card-body">
                <div class="h4 m-0"><img src="{{asset('/img/icons/'.$types[1]->icon)}}" ></div>
                <div>{{$types[1]->name}}</div>
                <h3>Coming Soon</h3>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection