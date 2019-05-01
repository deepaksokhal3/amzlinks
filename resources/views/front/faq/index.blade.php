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
                              <h2 class="h1-responsive font-weight-bold mt-sm-5 text-center wow fadeInDown"> Knowledge base</h2>
                              <hr class="hr-light wow fadeInLeft">
                              <h4 class="text-center wow fadeInDown">Have a question? Here we can help you.</h4>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="section section-landing bg-white pb-0">
               <div class="container">
                  <div class="row d-flex justify-content-center">
                     @if(count($catagories) > 0)
                     @foreach($catagories as $catagory)
                     <div class="col-md-4 col-sm-6 pb-5 wow zoomIn">
                        <a href="{{ URL::to('/faq/'.$catagory->id)}}" class="btn btn-outline-primary btn-lg d-block py-4">{{ $catagory->name}}</a>
                     </div>
                     @endforeach
                     @endif
                  </div>
               </div>
               <hr>
            </section>
            <section class="section section-landing py-0">
               <div style="background-image: url('images/knowledge-base.jpg');background-size: cover;background-position: center">
                  <div class="text-center d-flex align-items-center rgba-white-strong pb-5">
                     <div class="container">
                        <h3 class="section-heading h3-more wow fadeInDown">
                           Can't find what you're looking for?
                        </h3>
                        <a href="{{ URL::to('/contact-us')}}" class="btn btn-primary btn-lg btn-md wow fadeInDown"> Contact Support</a>
                     </div>
                  </div>
               </div>
            </section>
            <!-- ManyChat -->
         </main>
      </div>
 @endsection