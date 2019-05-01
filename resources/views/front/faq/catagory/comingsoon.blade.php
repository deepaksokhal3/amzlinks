 @extends('layouts.front-home')
 @section('content')
 <div class="app-body in-home">
         <main class="main">

            <div class="bg-light after-header-section">
               <div class="container">
                  <ul class="breadcrumb bg-light mb-0">
                      <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ URL::to('/faq')}}">FAQ</a></li>
                  </ul>
               </div>
            </div>
            <div class="bg-white py-5">
               <div class="container">
                  <div class="row">
                     @include('front.faq.catagory.side')
                   <div class="col-sm-12 col-xl-8">
                   </br>
                    </br>
                     </br>
                      </br>
                        <div class="card-body">
                          <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                              <h1 class="display-3 text-center">Coming Soon</h1>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
               </div>
            </div>

            <section class="section section-landing py-0">
               <div class="bg-light">
                  <div class="text-center d-flex align-items-center py-5">
                      <div class="container">
                          <h3 class="section-heading h3-more">
                              Can't find what you're looking for?
                          </h3>
                          <a href="{{ URL::to('/contact-us')}}" class="btn btn-primary btn-lg btn-md"> Contact Support</a>
                      </div>
                  </div>
               </div>
            </section>

         </main>
      </div>
@endsection