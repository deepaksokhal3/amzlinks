@extends('layouts.app')
@section('content')
<!-- Main content -->
<main class="main subscriptionPage">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Subscription</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
    <div class="container">
        <div class="animated fadeIn">
             @if(Session::has('messagePlan'))
            <div class="alert {{ Session::get('alert-class') }}">{{ Session::get('messagePlan') }}</div>
            @endif
            @if(Session::has('success'))
            <div class="alert {{ Session::get('alert-class1') }}">{{ Session::get('success') }}</div>
            @endif
            <div class="row no-gutters paymentCards">
                 @foreach($plans as $key => $plan)

                <div class="col-md px-1 wow zoomIn">
                        <div class="card pricing-card">
                            @if($key != 0)
                                 <div class="card-header py-3 position-relative card-header2" align="center">
                                    <span style="background-color:#ba2d64;top:-36px;left:0;width: 100%;" class="text-white d-block position-absolute py-2">MOST POPULAR</span>
                                    <h3>{{$plan->name}}</h3>
                                 </div>
                              @else
                                 <div class="card-header py-3 position-relative card-header1" align="center">
                                    <h3>{{$plan->name}}</h3>
                                 </div>
                              @endif
                            <div class="card-body" align="center">
                                <h1 class="py-4">${{number_format($plan->cost, 2)}}<p class="text-muted">user/mo</p></h1>

                                 @php
                                    $terms = json_decode($plan->description);
                                 @endphp
                                 <ul align="left" class="list-unstyled check_ul">
                                    @foreach($terms as $term)
                                    <li>{{ $term }}</li>
                                    @endforeach
                                 </ul>
                            </div>
                           <div class="card-footer">
                               @if($key != 0)
                               @if($subscription->stripe_plan == $plan->plan_id && !$subscription->ends_at)
                                 <a href="{{ route('subscription.cancel', $plan->slug)}}" class="btn btn-danger btn-block">
                                   <i class="fa fa-times-circle-o"></i> Cancel
                                   </a>
                                   @else
                                    <a href="{{ route('subscription.show', $plan->slug)}}" class="btn btn-primary btn-block">
                                      Buy Now
                                      </a>
                                   @endif

                                 @else
                                  <a href="{{ Auth::check()? 'javascript:;':route('register')}}" class="btn btn-primary btn-block">
                                    @if($subscription->stripe_plan == $plan->plan_id)
                                   <i class="fa fa-check-circle"></i> Active
                                   @else
                                      Try Now
                                   @endif
                                 </a>
                              @endif
                            </div>
                        </div>
                </div>
                @endforeach
                <div class="col-md px-1">
                    <div class="card pricing-card">
                        <div class="card-header py-3 position-relative card-header4" align="center">
                            <h3 style="color:#fff;">Elite</h3>
                        </div>
                        <div class="card-body" align="center">
                            <p class="pt-5">Contact us for more details</p>

                        </div>
                        <div class="card-footer">
                            <a href="{{ URL::to('contact-us')}}" class="btn btn-primary btn-block">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection