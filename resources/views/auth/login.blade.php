@extends('layouts.withoutheader') @section('content')
<div class="container login-form">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body">
                    <div class="sin-up-hadr">
                        <div class="sing-log">
                             <a href="{{ URL::to('/')}}"><img src="{{ asset('logo/logo.png')}}"></a>
                        </div>
                        <div class="go-to-home">
                            <a href="/"><i class="fa fa-home"></i></a>
                        </div>
                        <h1 class="text-center">Sign in</h1>
                        <h6 class="text-center sing-log">Create new account in Amzlinks.com?
                              <a href="{{ URL::to('register')}}" >Sign up</a>
                            </h6>
                        <div class="col-md-12">
                            <a class="btn btn-block btn-facebook" href="{{url('/redirect')}}">
                                <span>Login with Facebook</span>
                            </a>
                        </div>
                        <br>
                        <h5 class="text-center or-text">
                            OR
                          </h5>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-user"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus placeholder="Email"> @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span> @endif
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password"> @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                        </span> @endif
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-primary px-4 act-btn">Login</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                               {{ __('Forgot Password?') }}
                               </a> @endif
                                <!-- <button type="button" class="btn btn-link px-0">Forgot password?</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection