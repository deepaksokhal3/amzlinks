@extends('layouts.app')

@section('content')
<!-- Main content -->
<main class="main">
  <!-- Breadcrumb -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
    <li class="breadcrumb-item active">Tracking Codes</li>
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
        <i class="fa fa-align-justify"></i> Tracking Codes
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-striped">
          <thead>
            <tr>
              <th>Code name</th>
              <th>Type</th>
              <th>Creation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if(count($trackingCodes) > 0)
            @foreach($trackingCodes as $trackingCode)
            <tr id="track-row-{{$trackingCode->id}}">
              <td>
                <h5> <a href="#" data-toggle="tooltip" data-placement="top" class="track-title"  title="" data-original-title="Show links">{{$trackingCode->trackTitle}} </a></h5>

              </td>
              <td><i class="{{$trackingCode->trackingType->icon}}"></i> {{$trackingCode->trackingType->name}}</td>
              <td> <span class="small text-muted" >{{ date('Y M, d h:i:a', strtotime($trackingCode->created_at))}}</span></td>
              <td>
                <a href="{{ URL::to('tracking/edit') }}" onclick="event.preventDefault(); document.getElementById('track-form-{{$trackingCode->id}}').submit();" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-danger" onclick="trackingCodeDelete({{$trackingCode->id}})" ><i class="fa fa-trash"></i></a>
                <form id="track-form-{{$trackingCode->id}}" action="{{ route('tracking.edit') }}" method="POST" style="display: none;">
                  @csrf
                  <input type="hidden" name="id" value="{{$trackingCode->id}}">
                </form>

              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <a href="{{ URL::to('tracking/add')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>{{ __('Create Tracking Code')}}</a>
      </div>
    </div>
  </div>
</div>
</main>
@endsection