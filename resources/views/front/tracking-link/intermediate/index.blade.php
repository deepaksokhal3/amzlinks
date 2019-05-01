<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amzlinks</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

</head>
@if($track)
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-138415243-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-138415243-1');
</script>
@endif
@if(!empty($links) && count($links->getSelectedTrackingCode) > 0)
@foreach($links->getSelectedTrackingCode as $getSelectedCode)

@if(strpos($getSelectedCode,'script') !== false && $track)
  {!! $getSelectedCode->getPixelCode->trackCode !!}
@endif
 @endforeach
@endif
<link href='//fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="{{ asset('css/amazon.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/custom.css')}}" />
<script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/js/bootstrap.min.js') }}"></script>

<body>
    <div class="lds-hourglass"></div>
    <div class="amazon-pr-contnr" style="display:none">
        @if(in_array($links->types,[2,3,4,8,9]))
        <div id="viewData">
            <div class="sec-left"> <img src="" alt="amaz product image"/></div>
            <div class="sec-right">
                <span class="brand"><img src=""/></span><h2></h2>
                <div class="directive-sec">
                    <span></span>
                    <div class="str-rating">
                        <i class="a-icon a-icon-star">
                            <span class="a-icon-alt">4.2 out of 5 stars</span>
                        </i>
                    </div>
                </div>
                <a id="redirectLnk" class="process-button" href='#' target="blank">
                  PROCEED TO AMAZON
                </a>
            </div>
        </div>
        <div  id="maz-footer-sec" class="a-box a-spacing-large a-spacing-top-small">
            <div class="a-box-inner">
                <div class="a-row a-spacing-small">
                    <div class="a-section a-spacing-none" role="region">
                        <h4 class="a-color-secondary">Search Feedback</h4><span>Did you find what you were looking for?</span>
                    </div>
                    <ul class="a-unordered-list a-nostyle a-button-list a-declarative a-button-toggle-group a-horizontal a-spacing-none a-spacing-top-micro">
                        <li><span class="a-list-item"><span class="a-button a-button-toggle"><span class="a-button-inner"><span class="a-button-text">Yes</span></span>
                            </span>
                            </span>
                        </li>
                        <li><span class="a-list-item"><span class="a-button a-button-toggle"><span class="a-button-inner"><span class="a-button-text">No</span></span>
                            </span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="a-row"><span>If you need help or have a question for Customer Service, please <a class="a-link-normal a-text-normal" href="https://www.amazon.in/gp/help/customer/display.html?nodeId=201889520">visit the Help Section</a>.</span></div>
            </div>
        </div>
        @endif
    </div>
    <div class="expire-link container" style="display:none;">
        <div class="card-expire">
        <h2>Sorry, the link has expired</h2>
        <p>The link was set to expire after certain hit.Please contact the person who shared this link with you.</p>
        </div>
         <hr>

    </div>
</body>
</html>
<script>
    jQuery(document).ready(function($) {
        jQuery('.lds-hourglass').css('height', $(window).height()).css('display', 'block');

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ URL::to('/ajax/'.request()->segment(1))}}",
            method: 'get',
            success: function(result) {
                jQuery('.lds-hourglass').css('display', 'none');
                var result = JSON.parse(result);
                if(result.expire){
                    jQuery('.expire-link').css('display','block')
                    return false;
                }

                if (result.target) {
                    jQuery('.amazon-pr-contnr').css('display', 'block');
                    try {
                        if(result.html.status){
                            jQuery('.sec-left img').attr('src',result.html.image)
                            if(result.html.brand){
                                jQuery('.brand img').attr('src',result.html.brand)
                            }else{
                                jQuery('.brand').css('display','none');
                            }
                            var a = document.getElementsByTagName('a');
                            for (var idx = 0; idx < a.length; ++idx) {
                                var res = a[idx].href.replace('keywords=' + result.asin, "");
                                a[idx].setAttribute('href', res);
                            }
                            jQuery('#redirectLnk').attr('href', result.redirect_url);
                            jQuery('#redirectLnk').css('display', 'block');
                            jQuery('.sec-right h2').text(result.html.title);
                            jQuery('.directive-sec span').text(result.html.price);
                            jQuery('.str-rating i').addClass('a-star-'+parseInt(result.html.rating.split(' ')[0]));
                            jQuery('.str-rating i .a-icon-alt').text(result.html.rating);
                        }else{
                            jQuery('#maz-footer-sec').css('display', 'none');
                            jQuery('#viewData').html('<div id="g"><div><a href="https://www.amazon.com/"><img src="https://m.media-amazon.com/images/G/01/error/title._TTD_.png"></a></div><a href="https://www.amazon.com/dogsofamazon" target="_blank"><img id="d" alt="Dogs of Amazon" src=""></a>');
                             document.getElementById("d").src="https://images-na.ssl-images-amazon.com/images/G/01/error/"+(Math.floor(Math.random()*43)+1)+"._TTD_.jpg";
                        }
                    } catch (err) {

                    }

                } else {
                    jQuery('#redirectLnk').css('display', 'none');
                    window.location.href = result.redirect_url;
                }
            }
        });
    });
</script>