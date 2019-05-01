@extends('layouts.app')

@section('content')
<!-- Main content -->
<main class="main">
  <!-- Breadcrumb -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
    <li class="breadcrumb-item active">Billing History</li>
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
        <i class="fa fa-align-justify"></i> Billing
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Status</th>
              <th>stripe Id</th>
              <th>Plan Id</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @if(count($hostory) > 0)
              @foreach($hostory as $subscription)
              <tr>
                <td> {{ date('Y M, d h:i:a', strtotime($subscription->created_at))}}</td>
                <td><span class="pmt-sts"> {{$subscription->name == 'Free'? strtoupper($subscription->name):'PAID'}}</span></td>
                <td>{{$subscription->stripe_id?$subscription->stripe_id:'-' }}</td>
                <td>{{$subscription->stripe_plan }}</td>
                <td>{{'AMZLinks.com '. $subscription->name.' Subscription' }}</td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="5">
              <a href="{{ URL::to('/subscription')}}" class="btn btn-primary btn-lg btn-block">Setup Subscription</a>
            </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>
@endsection