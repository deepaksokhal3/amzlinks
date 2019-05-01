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
                        <h1 class="h1-responsive text-center font-weight-bold mt-sm-5 wow fadeInUp" data-wow-delay="0.3s"> Contact us</h1>
                        <hr class="hr-light wow fadeInLeft" data-wow-delay="0.3s">
                        <h4 class="text-center wow fadeInUp" data-wow-delay="0.3s">Need help with your account? Please contact us using the form below.
                        </h4>
                        <br>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--Section: Contact v.2-->
      <section class="section bg-white">
         <div class="container">
            <div class="row pt-5">
               <!--Grid column-->
               <div class="col-md-8 offset-md-2 mb-md-0 mb-5 wow fadeInUp">
                   @if(session('success'))
                       <div class="alert alert-success alert-block text-left">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <strong>{{session('success')}}</strong>
                       </div>
                    @endif
                    @if(session('errors'))
                       <div class="alert alert-danger alert-block text-left">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <strong>{{session('errors')->first('validMail')}}</strong>
                       </div>
                    @endif
                  <form id="contact-form" method="POST"  action="{{route('send.sendContactUsMail')}}" class="fv-form fv-form-bootstrap4" >
                     @csrf
                     <!--Grid row-->
                     <div class="row">
                        <!--Grid column-->
                        <div class="col-md-6">
                           <div class="md-form form-group mb-0 fv-has-feedback">
                              <label for="name" class="">Name<em>*</em></label>
                              <input type="text" id="name" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" data-fv-field="name" value="{{ old('name') }}">
                              @if ($errors->has('name'))
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                              </span>
                              @endif

                           </div>
                        </div>
                        <!--Grid column-->
                        <!--Grid column-->
                        <div class="col-md-6">
                           <div class="md-form form-group mb-0 fv-has-feedback">
                              <label for="email" class="">Email address<em>*</em></label>
                              <input type="text" id="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" data-fv-field="email" value="{{ old('email') }}">
                              @if ($errors->has('email'))
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('email') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                        <!--Grid column-->
                     </div>
                     <!--Grid row-->
                     <!--Grid row-->
                     <div class="row pt-4">
                        <!--Grid column-->
                        <div class="col-md-12">
                           <div class="md-form form-group fv-has-feedback">
                              <label for="message">Message <em>*</em></label>
                              <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea textarea-md {{ $errors->has('message') ? ' is-invalid' : '' }}" data-fv-field="message">{{ old('message') }}</textarea>
                              @if ($errors->has('message'))
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('message') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <!--Grid row-->
                     <div class="text-center py-3">
                        <button type="submit" class="btn pxf-btn btn-lg"><i class="fa fa-paper-plane" data-original-title="" title=""></i> Send</button>
                     </div>
                  </form>
               </div>
               <!--Grid column-->
            </div>
         </div>
      </section>
      <!-- ManyChat -->

   </main>
</div>
@endsection