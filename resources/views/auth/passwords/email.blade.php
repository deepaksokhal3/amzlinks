@extends('layouts.withoutheader')

@section('content')


<div class="container  login-form">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card mx-4">
                <div class="card-body">
                        <div class="sin-up-hadr">
                            <div class="sing-log">
                                <img src="{{ asset('logo/logo.png')}}">
                            </div>

                            <h1 class="text-center">{{ __('Reset Password') }}</h1>

                        </div>
                    <form method="POST" action="{{ route('password.email') }}">
                         @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"><em class="err" style="color:red;">*</em></i></span>
                            </div>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-primary px-4">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
