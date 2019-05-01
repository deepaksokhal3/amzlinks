@extends('layouts.front-home')
@section('content')
      <div class="app-body in-home">
         <main class="main">
            <section class="view black-bg">
               <div class="full-bg-img">
                  <div class="container flex-center">
                     <div class="row flex-center py-5">
                        <div class="text-center text-md-left margins">
                           <div class="white-text py-5">
                              <h1 class="h1-responsive font-weight-bold mt-sm-5 wow fadeInDown"> Simple pricing. Pay as you grow.</h1>
                              <p class="text-center wow fadeInDown">Track your links and <strong>improve the rankings of your products </strong>on Amazon.
                              </p>
                              <br>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section id="myplns" class="section section-landing text-center bg-white pricing-plans">
               <div class="container">
                  <h2 class="section-heading h2-more wow fadeInDown">Our pricing plans</h2>
                  <p class="section-description wow fadeInDown">Plans that grow with your business</p>
                  <div class="row no-gutters">
                    @foreach($plans as $key => $plan)
                      <div class="col-md px-1 wow zoomIn">
                           <div class="card pricing-card">
                               @if($key != 0)
                                 <div class="card-header py-3 position-relative card-header2" align="center">
                                    <span style="background-color:#ba2d64;top:-36px;left:0;width: 100%;" class="text-white d-block position-absolute py-2">MOST POPULAR</span>
                                    <h3>{{$plan->name}}</h3>
                                 </div>
                              @else
                                 <div class="card-header py-3 position-relative  bg-secondary card-header1" align="center">
                                    <h3>{{$plan->name}}</h3>
                                 </div>
                              @endif
                              <div class="card-body" align="center">
                                 <h1 class="py-4">
                                    ${{number_format($plan->cost, 2)}}
                                    <p class="text-muted">user/mo</p>
                                 </h1>
                                 @php
                                    $terms = json_decode($plan->description);
                                 @endphp
                                 <ul align="left" class="list-unstyled">
                                    @foreach($terms as $term)
                                    <li>{{ $term }}</li>
                                    @endforeach
                                 </ul>
                              </div>
                              <div class="card-footer">
                               @if($key != 0)
                               @if(isset($subscription->stripe_plan) && $subscription->stripe_plan == $plan->plan_id && !$subscription->ends_at)
                                 <a href="{{ route('subscription.cancel', $plan->slug)}}" class="btn btn-primary btn-block">
                                   <i class="fa fa-times-circle-o"></i> Cancel
                                   </a>
                                   @else
                                    <a href="{{ route('subscription.show', $plan->slug)}}" class="btn btn-primary btn-block">
                                      Buy Now
                                      </a>
                                   @endif

                                 @else
                                  <a href="{{ Auth::check()? 'javascript:;':route('register')}}" class="btn btn-primary btn-block">
                                    @if( isset($subscription->stripe_plan) && $subscription->stripe_plan == $plan->plan_id)
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
                     <div class="col-md px-1 wow zoomIn">
                        <div class="card pricing-card">
                           <div class="card-header py-3 card-header4" align="center">
                              <h3 >Elite</h3>
                           </div>
                           <div class="card-body" align="center">
                              <p class="pt-5">Contact us for more details</p>
                           </div>
                           <div class="card-footer">
                              <a href="{{URL::to('/contact-us')}}" class="btn btn-primary">Contact Us</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="section section-landing py-4">
               <div>
                  <div class="text-center d-flex align-items-center pb-4 px-4">
                     <div class="container">
                        <h3 class="section-heading h3-more mt-3 mb-4">
                           Signup Today For Free
                        </h3>
                        <p class="section-description mb-4">Welcome to the only <strong>Amazon shortener and tracking tool</strong> and take your business to new heights!
                        </p>
                        <a href="{{  Auth::check() ?'#myplns':route('register')}}" class="btn btn-success btn-lg btn-md"> GET STARTED!</a>
                     </div>
                  </div>
               </div>
            </section>
            <!-- ManyChat -->

         </main>
      </div>
      @endsection