<div class="sidebar">
  <nav class="sidebar-nav">

    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/dashboard')}}"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-info">NEW</span></a>
      </li>
      <li class="nav-title">
        CAMPAIGNS
      </li>
      <li class="nav-item">
        <a href="{{URL::to('/campaigns')}}" class="nav-link" ><i class="fa fa-folder-open"></i> {{__('My Campaigns')}}</a>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/campaign/add')}}" class="nav-link"  ><i class="fa fa-plus"></i> {{__('Create Campaign')}}</a>
      </li>
      <li class="nav-title">
        TRACKING CODES
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/trackings')}}" class="nav-link"  ><i class="fa fa-telegram"></i> {{__('My Tracking Codes')}}</a>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/tracking/add')}}" class="nav-link"  ><i class="fa fa-plus"></i> {{__('Add a Tracking Code')}}</a>
      </li>
      <li class="nav-title">
        TRACKING LINKS
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/tracking-links')}}" class="nav-link"  ><i class="fa fa-line-chart"></i> {{__('My Tracking Links')}}</a>
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/tracking-links/select')}}" class="nav-link {{ Helper::checkSubscription()?'':'not-active'}}"  ><i class="fa fa-plus"></i> {{__('Add a Tracking Link')}}</a>
      </li>
      <li class="nav-title">
        FAQ
      </li>
      <li class="nav-item">
        <a href="{{ URL::to('/faq')}}" class="nav-link"  ><i class="fa fa-question-circle"></i> {{__('FAQ')}}</a>
      </li>

    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>