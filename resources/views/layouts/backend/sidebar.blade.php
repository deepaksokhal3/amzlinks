<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/admin')}}"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-info">NEW</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/admin/users')}}"><i class="fa fa-users"></i> Manage Users </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/admin/campaigns')}}"><i class="fa fa-folder-open"></i> Manage Campaigns </a>
      </li>
      <li class="nav-item nav-dropdown" >
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-cursor"></i> Manage FAQ</a>
         <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('faq.index')}}"><i class="fa fa-folder-open"></i>FAQ Catagory</a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="{{ route('page.index')}}"><i class="fa fa-folder-open"></i>FAQ Pages</a>
            </li>
        </ul>
      </li>

    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>