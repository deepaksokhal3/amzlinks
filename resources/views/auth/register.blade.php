@extends('layouts.withoutheader') @section('content')

<div class="container register-form">
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
                        <h1 class="text-center">Sign Up</h1>
                        <h6 class="text-center sing-log">Already have a AmzLinks.com account?
                              <a href="{{ URL::to('login')}}" >Sign in</a>
                            </h6>
                        <div class="col-md-12">
                            <a class="btn btn-block btn-facebook" href="{{url('/redirect')}}">
                                <span>Login with Facebook</span>
                            </a>
                        </div>
                        <br>
                        <h5 class="text-center or-text">OR</h5>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-user"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"  autofocus placeholder="Name"> @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span> @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"> <em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="Email"> @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span> @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  placeholder="Password"> @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span> @endif
                        </div>

                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  placeholder="Confirm password">
                        </div>
                        <button type="submit" class="btn btn-block btn-primary act-btn">{{ __('Create Account') }}</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection