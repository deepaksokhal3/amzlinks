
<header class="app-header navbar" id="app-header-Home">
   <div class="container">
      <a class="navbar-brand" href="{{URL::to('/')}}">
        <img class="navbar-brand-full logo-pix" src="{{ asset('logo/logo.png')}}" alt="amzlinks Logo">
      </a>
      <ul class="nav navbar-nav d-md-down-none mx-auto">
         <li class="nav-item px-3">
            <a class="nav-link" href="{{URL::to('/pricing')}}">Pricing</a>
         </li>
         <li class="nav-item px-3">
            <a class="nav-link" href="{{URL::to('/faq')}}">FAQ</a>
         </li>
         <li class="nav-item px-3">
            <a class="nav-link" href="{{URL::to('/contact-us')}}">Contact Us</a>
         </li>
      </ul>
      @if (Auth::guest())
      <ul class="nav navbar-nav nav-user ml-auto mr-3">
         <li class="nav-item"><a href="{{URL::to('/login')}}" class="nav-link">Login</a></li>
         <li class="nav-item"><a href="{{URL::to('/register')}}" class="nav-link">Sign Up</a></li>
      </ul>
      @else
      <ul class="nav navbar-nav nav-user ml-auto mr-3">
         <li class="nav-item"><a href="{{URL::to(Auth::user()->role == 'admin'?'/admin':'/dashboard')}}" class="nav-link">Dashboard <i class="fa fa-arrow-right"></i></a></li>
      </ul>
      @endif
   </div>
</header>