    <div class="col-md-3">
      <h5 class="fw-bold mt-3">Categories</h5>
      <ul class="list-group list-group-flush links-categories">
         @if(count($catagories) > 0)
         @foreach($catagories as $catagory)
         <li class="list-group-item d-flex justify-content-between align-items-center border-0 bg-transparent {{ $tab == $catagory->id?'active':''}}">
            <a href="{{ URL::to('/faq/'.$catagory->id)}}">{{$catagory->name}}</a>
         </li>
         @endforeach
         @endif

      </ul>
   </div>