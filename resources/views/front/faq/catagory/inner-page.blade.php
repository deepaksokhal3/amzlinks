 @extends('layouts.front-home') @section('content')
<div class="app-body in-home">
    <main class="main">
        <div class="bg-light after-header-section">
            <div class="container">
                <ul class="breadcrumb bg-light mb-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL::to('/faq')}}">FAQ</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL::to('/faq/'.$page->getCatagories->id)}}">{{$page->getCatagories->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>
                </ul>
            </div>
        </div>
        <div class="bg-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h2 class="font-weight-bold">{{$page->title}}</h2>
                        <small>Created: {{$page->created_at->format('M d, Y')}} </small>
                        <div class="post-content py-3">{!! html_entity_decode($page->description) !!}</p>
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