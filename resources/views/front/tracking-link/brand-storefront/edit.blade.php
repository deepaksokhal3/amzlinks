@extends('layouts.app') @section('content')

<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Create Tracking Link</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <strong>Edit </strong>({{$link->getUrlType->name}})
                </div>
                 @if($errors->has('error'))
                <div class="alert alert-danger alert-block text-left">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{$errors->first('error')}}</strong>
                </div>
                @endif
                {!! Form::model($link, ['route' => ['brand.update',$link->id], 'method' => 'PATCH'])!!}
                    @include('front.tracking-link.brand-storefront.form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                    </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</main>
@endsection