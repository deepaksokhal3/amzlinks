

		    <script>
               $(document).ready(function(){
                   $(window).scroll(function() {
                       var topwin;
                       topwin = $(this).scrollTop();
                       if (topwin > 100) {
                           $('#app-header-Home').addClass('in-down');
                       } else {
                           $('#app-header-Home').removeClass('in-down');
                       }
                       return false;
                   });
               });
            </script>
		<footer class="frontend pt-4 pb-4">
         <div class="container">
            <div class="text-center"><a href="./"><img src="{{ asset('logo/logo.png')}}" height=""  width=""/></a></div>
            <!--ul class="nav justify-content-center">
               <li class="nav-item px-3 justify-content-md-center">
                  <a class="nav-link" href="{{URL::to('/pricing')}}">Pricing</a>
               </li>
               <li class="nav-item px-3 justify-content-md-center">
                  <a class="nav-link" href="{{URL::to('/faq')}}">FAQ</a>
               </li>
               <li class="nav-item px-3 justify-content-md-center">
                  <a class="nav-link" href="{{URL::to('/contact-us')}}">Contact Us</a>
               </li>
            </ul-->
         </div>
         <hr>
         <div class="container">
            <div class="row">
               <div class="col privacy">
                <ul class="nav">
                    <li>
                      <a href="{{URL::to('/pricing')}}">Pricing</a>
                   </li>
                   <li>
                      <a href="{{URL::to('/faq')}}">FAQ</a>
                   </li>
                   <li>
                      <a href="{{URL::to('/contact-us')}}">Contact Us</a>
                   </li>
                   <li>
                    <a href="{{URL::to('/policy')}}" target="_blank">Privacy Policy</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/terms')}}" target="_blank">Terms of Service</a>
                  </li>
                </ul>
               </div>
               <div class="col text-right">
                  <span>© Copyright 2019</span>
               </div>
            </div><br>
            <div class="row">
              <p class="col">
              <small>AMZLinks.com is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to Amazon.com</small>
            </p>
            </div>
         </div>
      </footer>