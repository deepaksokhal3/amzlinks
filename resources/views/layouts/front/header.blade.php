<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ URL::to('/')}}"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none mr-auto">

    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                      <img src="{{ asset(Auth::user()->image? 'images/35X35'.Auth::user()->image:'img/avatars/6.jpg')}}" class="img-avatar" alt="">
                    </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <span>{{Auth::user()->email}}</span>
                </div>
                <a class="dropdown-item" href="{{URL::to('/profile')}}"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="{{ URL::to('/subscription')}}"><i class="fa fa-usd"></i> My Subscription</a>
                <a class="dropdown-item" href="{{ URL::to('/change-password')}}"><i class="fa fa-lock"></i> Change Password</a>
                <!-- <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> Settings</a> -->
                <a class="dropdown-item" href="{{ URL::to('billing')}}"><i class="fa fa-usd"></i> Billing History</a>
                <div class="divider"></div>
                <!-- <a class="dropdown-item" href="#"><i class="fa fa-shield"></i> Lock Account</a> -->
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>
<div class="app-body">
@include('layouts.front.sidebar')
