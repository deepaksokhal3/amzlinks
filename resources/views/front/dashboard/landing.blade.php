@extends('layouts.front-home')
@section('content')
      <div class="app-body in-home">
         <main class="main">
            <section class="view view-full home pt-5 pb-3 first-section">
               <div class="full-bg-img">
                  <div class="container flex-center">
                     <div class="row">
                        <div class="col-md-12 text-center wow fadeInDown">
                           <div class="text-center mb-5">
                              <h1 class="h1-responsive font-weight-bold pt-5 mt-sm-5 text-white" data-wow-delay="0.3s">Link Rotation & Tracking Tool for Amazon Sellers</h1>
                              <h2 class="h2-responsive font-weight-bold text-white">Driving Traffic & Rank on Amazon with Ease</h2>
                           </div>
                        </div>
                        <div class="col-md-7 banner-left-sec text-center wow fadeInLeft">
                           <div class="text-center mb-1">
                              <div class="py-3 w-100" style="max-width:800px;margin:0 auto;">

                                 <img src="{{ asset('img/amzlink1.png') }}" alt="" class="img-fluid shadow rounded">

                              </div>
                           </div>
                        </div>
                        <div class="col-md-5 banner-right-sec wow fadeInRight">
                           <div class="mb-5">
                              <p class="mt-5 text-white">If you are an Amazon seller who is driving traffic to Amazon through social media, email, or ChatBot campaigns, this is the only linking tool you will ever need.</p>
                              <br>
                              <p class="mb-4 text-white">Create shortened links, track clicks with your Facebook pixels and Google tags, and rotate through hundreds or thousands of keywords to rank on page one of Amazon like a professional.</p>
                              <a class="btn btn-lg btn-success" href="{{  Auth::check() ?'#myplns':route('register')}}">Sign Up Today For Free</a>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
               <ul class="star" style="position: absolute;left: 14%;top: 190px;">
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
               </ul>
               <ul class="star" style="position: absolute;left: 50%;bottom: 100px;">
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
               </ul>
               <ul class="star" style="position: absolute;left: 54%;top: 130px;">
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                  </ul>
               <div class="rocket">
                  <div class="rocket-body">
                     <div class="body"></div>
                     <div class="fin fin-left"></div>
                     <div class="fin fin-right"></div>
                     <div class="window"></div>
                  </div>
                   <div class="exhaust-flame"></div>
                     <ul class="exhaust-fumes">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                     </ul>
                     <ul class="star">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                     </ul>
               </div>
            </section>
            <section class="section section-landing bg-white how-it-works">
               <div class="container">
                  <h2 class="section-heading h2-more wow fadeInDown">How it works</h2>
                  <p class="section-description wow fadeInDown">With AMZLinks.com you can create and track any type of Amazon link that you need for your marketing campaigns. 2-Step URLs, Hidden Field URLs, Search-Find-Buy URLs, and any custom URL you want to drive traffic to. We have made it easy for you to track link clicks and rotate through as many keywords as you want to rank for.
                  </p>
                  <div class="row">
                     <div class="col-md-12 pb-4">
                        <div class="row">
                           <div class="col text-center">
                              <img src="{{ asset('img/create.png') }}" class="pb-4 img-fluid  wow fadeInLeft">
                           </div>
                           <div class="col pl-5 align-self-center  wow fadeInRight">
                              <h3 class="mt-3">Create</h3>
                              <p class="grey-text">Sending traffic from Facebook? Use this tool to create and shorten your Amazon links with retargeting pixels from Facebook and Google. You can also easily add in as many keywords as you would like so you can rank for long-tail keywords with ease.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 pb-4">
                        <div class="row">
                           <div class="col pl-5 align-self-center  wow fadeInLeft">
                              <h3 class="mt-3">Share</h3>
                              <p class="grey-text">Plug your links into your campaigns on Facebook, Google, eMail, ChatBots, or YouTube. You can create custom conversions on Facebook or Google and track performance of your campaigns with ease.</p>
                           </div>
                           <div class="col text-center  wow fadeInRight">
                              <img src="{{ asset('img/sharing.jpg') }}" class="pb-4 img-fluid">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 pb-4">
                        <div class="row">
                           <div class="col text-center wow fadeInLeft">
                              <img src="{{ asset('img/track.jpg') }}" class="pb-4 img-fluid">
                           </div>
                           <div class="col pl-5 align-self-center wow fadeInRight">
                              <h3 class="mt-3">Track</h3>
                        <p class="grey-text">Track clicks on all of your campaigns and monitor performance using our analytics dashboard. Our tool makes it as easy as eating a slice of apple pie.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row text-center wow fadeInDown">
                     <div class="col">
                        <a class="btn btn-lg btn-success" href="{{  Auth::check() ?'#myplns':route('register')}}">Sign Up Today For Free</a>
                     </div>
                  </div>
               </div>
            </section>
            <section class="section section-landing bg-light ">
               <div class="container">
                  <h2 class="section-heading h2-more wow fadeInDown">Rank on Page One with AMZLinks.com</h2>
                  <div class="row d-flex">
                     <div class="col-lg-5 mb-lg-0 mb-5 order-md-1 order-2 wow fadeInLeft">
                        <img src="{{ asset('img/amzlink1.png') }}" alt="Sample project image" class="img-fluid rounded z-depth-1">
                     </div>
                     <div class="col-lg-7 order-md-2 order-1 wow fadeInRight">
                        <div class="row mb-3">
                           <div class="col-md-11 col text-center text-md-left">
                              <h5 class="font-weight-bold mb-3">Why is AMZLinks so Powerful?</h5>
                              <p class="grey-text">We help you shorten your links and embed pixels and tracking codes into your links. This helps you not only create links that help you earn organic rank on Amazon, but it also gives you the ability to monitor performance of your links, and create custom audiences based on who clicks the link.
                              </p>
                              <p><strong>Example:</strong>
                                 You are trying to rank your lavender essential oil product using ManyChat.
                              </p>
                              <p class="grey-text">Use a shortened URL Rotator link, plug in 50 keywords, and run a ranking campaign. You can create a custom audience on Facebook that consists of people who have clicked your shortened link. This allows you to target anyone who clicked this link on Facebook, whether your aim is to retarget them or to simply use that warm audience for your next launch campaign.</p>
                              <a class="btn btn-primary" href="{{  Auth::check() ?'#myplns':route('register')}}">Sign Up Today For Free</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr class="my-5">
                  <div class="row">
                     <div class="col-lg-7 wow fadeInLeft">
                        <div class="row mb-3">
                           <div class="col-md-11 col text-center text-md-left">
                              <h5 class="font-weight-bold mb-3">What is a URL Rotator and Why Should I Care?</h5>
                              <p class="grey-text">Our URL rotator will allow you to link to tens, hundreds, or thousands of keywords using <strong>just one link!</strong> This allows you to create a campaign and link to potentially thousands of keywords at once. By doing this, you could earn ranks on Amazon for long-tail low competition keywords in the most efficient way possible. One Facebook campaign can boost ranks for <strong>all of your keywords.</strong>
                              </p>
                              <a class="btn btn-primary" href="{{  Auth::check() ?'#myplns':route('register')}}">Sign Up Today For Free</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-5 wow fadeInRight">
                        <img src="{{ asset('img/amzlink2.png') }}" alt="Sample project image" class="img-fluid rounded z-depth-1">
                     </div>
                  </div>
                  <hr class="my-5">
                  <div class="row">
                     <div class="col-lg-5 mb-lg-0 mb-5 order-md-1 order-2 wow fadeInLeft">
                        <img src="{{ asset('img/amzlink1.png') }}" alt="Sample project image" class="img-fluid rounded z-depth-1">
                     </div>
                     <div class="col-lg-7 order-md-2 order-1 wow fadeInRight">
                        <div class="row mb-3">
                           <div class="col-md-11 col text-center text-md-left">
                              <h5 class="font-weight-bold mb-3">Who needs to use AMZLinks?</h5>
                              <p class="grey-text"><strong>Any Amazon seller who is driving traffic to Amazon listings should be using AMZLinks.com.</strong> It is not only the most powerful linking tool on the market, we also offer a free plan so you can try it for yourself. No credit card required. We’re that confident.
                              </p>
                              <a class="btn btn-primary" href="{{  Auth::check() ?'#myplns':route('register')}}">Sign Up Today For Free</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="section section-landing bg-white logos-integrate text-center">
               <div class="container">
                 <h2 class="section-heading h2-more mt-3 mb-4 wow fadeInDown">Seamless integration with</h2>
                  <div class="row justify-content-md-center wow fadeInDown">
                     <div class="col-md-auto">
                        <img src="{{ asset('img/amazon-logo-pixelfy.png') }}" alt="amazon" class="img-fluid">
                     </div>
                     <div class="col-md-auto">
                        <img src="{{ asset('img/ganalytics-logo-pixelfy.png') }}" alt="ganalytics" class="img-fluid">
                     </div>
                     <div class="col-md-auto">
                        <img src="{{ asset('img/facebook-logo-pixelfy.png') }}" alt="facebook" class="img-fluid">
                     </div>
                  </div>
               </div>
            </section>
            <section class="section section-landing py-0">
                  <div class="text-white text-center d-flex align-items-center rgba-blue-strong py-5 px-4">
                     <div class="container wow fadeInDown">
                        <h2 class="section-heading h2-more mt-3 mb-3">
                           Sign Up Today For Free
                        </h2>
                        <p class="section-description text-white mb-4">Welcome to the only <strong>Amazon shortener and tracking tool</strong> and take your business to new heights!
                        </p>
                        <a href="{{  Auth::check() ?'#myplns':route('register')}}" class="btn btn-lg btn-success"> GET STARTED!</a>
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
                               @if( isset($subscription->stripe_plan) && $subscription->stripe_plan == $plan->plan_id && !$subscription->ends_at)
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
                                    @if(isset($subscription->stripe_plan) && $subscription->stripe_plan == $plan->plan_id)
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
                              <h3>Elite</h3>
                           </div>
                           <div class="card-body" align="center">
                              <p class="pt-5">Contact us for more details</p>
                           </div>
                           <div class="card-footer">
                              <a href="{{ URL::to('/contact-us')}}" class="btn btn-primary">Contact Us</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </main>
      </div>
@endsection
