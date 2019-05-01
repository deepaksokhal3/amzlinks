@extends('layouts.app')
@section('content')

<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Change Password</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card pxf-card-admin">

                <div class="card-header">
                    <i class="fa fa-lock"></i>Set Password</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <p>
                                Use the following form to modify your password. Your password should be at least 8 characters. We highly recommend you to use numbers, letters, punctuation characters. </p>

                        </div>
                        <div class="col-lg-6">
                            @if ($errors->has('error'))
                                <div class="alert alert-danger text-left">
                                    {{ $errors->first('error') }}
                                </div>
                                @endif
                               @if ($errors->has('success'))
                                <div class="alert alert-success alert-block text-left">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $errors->first('success') }}</strong>
                                </div>
                                @endif
                            <form  method="post" action="{{ route('changePassword')}}" class="fv-form fv-form-bootstrap4">
                                @csrf
                                <div class="form-group fv-has-feedback">
                                    <label for="current-password" class="form-control-label">Current password <em class="danger">*</em></label>
                                    <div class="controls">
                                        <input class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}" type="password" name="current_password">
                                        @if ($errors->has('current_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                                    </div>
                                </div>

                                <div class="form-group fv-has-feedback">
                                    <label for="new-password" class="form-control-label">New password <em class="danger">*</em></label>
                                    <div class="controls">
                                        <input class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" type="password" name="new_password">
                                        @if ($errors->has('new_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                                @endif
                                    </div>
                                </div>
                                <div class="form-group fv-has-feedback">
                                    <label for="new-password-check" class="form-control-label">Confirm password <em class="danger">*</em></label>
                                    <div class="controls">
                                        <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password"  name="password_confirmation" >
                                        @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">
                                    Update password </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
@endsection