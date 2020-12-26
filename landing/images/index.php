<?php header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Live BroadCast</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<style>
.sidebar-container{
    -webkit-transition: max-width .3s ease-in-out;
    transition: max-width .3s ease-in-out;
    max-width:25rem;
}
body.sidebar-show .sidebar-container {
    max-width:24px;
}
.main-container {
	background: rgb(17, 17, 17);
	max-width: 100%;
	min-height: 100vh;
	position: relative;
}
.side_footer {
	height: 8 rem;
	background: #fafafa;
	padding: 1.25rem;
	border-top: 1px solid rgba(0, 0, 0, .06);
}

.main-container:before {
	content: "";
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	background: url(__assets/images/body_bg.jpg) 50%;
	background-size: cover;
	opacity: .1;
}

.video-container video {
	width: 100%;
}
.video-container {
	width: 80%;
	height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.video-container iframe {
	display: block;
	width: 100%;
	height: 720px;
	border: none;
}

.side_footer textarea.form-control {
    height: 3rem;
    resize: none;
}
.offerfiv {
    width:auto; 

}
@media only screen and (max-width: 480px) {
    .theme_1 .card {
    background: #fff;
    height: 500px;
}
    .offerfiv {
     position: fixed; 
    background: #fff;
    bottom:138px;
    left: 0;
    right: 0;
}
.offerfiv .card{
    height:auto;
}
.side_footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
}
	.layout-renderer-container {
		align-items: baseline !important;
	}
	
	.video-container {
		width: 100%;
		min-height: 230px;
	}
	
	.layout-renderer-container {
		flex: none !important;
	}
	
	.top_content_wrapper {
		flex-direction: column;
	}
	
	.sidebar-container {
		max-width: 100% !important;
	}
	
	.liveroom_sidebar {
		padding-left: 0px !important;
		width: 100% !important;
	}
	
	.btn-expander-left {
		display: none;
	}
}
.liveroom_sidebar {
    height: 100vh !important;
}
.top-icons{
    width:100%;
}
.top-icons .label{
    color:#fff;
}
.top-icons .label fa{
    margin-bottom:10px;
}
.offer_txt {
	font-size: 1rem;
	font-family: Roboto, -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
	text-decoration: underline;
	text-decoration-color: #f6c733;
	text-decoration-thickness: 0.1em;
	color: black !important;
    padding-left: 10px;
    padding-right:10px;
    margin-bottom: 0;
    display:flex;
    align-items: center;
    justify-content: space-between;
}

.offermain {
	box-shadow: 0 -5px 5px rgba(0, 0, 0, .1);
	border: 1px solid #ccc;
	background: #fafafa;
	margin: 0px;
	padding: 0px;
}

.offer_txt:hover {
	font-size: 1rem;
	font-family: Roboto, -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
	text-decoration: underline;
	text-decoration-color: #f6c733;
	text-decoration-thickness: 0.1em;
	color: black !important;
}

.offer_exp {
	background: #fff9c4;
	color: #000;
	border-color: #e0e0e0;
	width: 100%;
	-webkit-box-flex: 0;
	flex: 0 0 100%;
	max-width: 100%;
	border-style: solid;
	border-width: 1px;
}

.alignleft {
	float: left;
	padding-top: 10px;
	padding-right: 0px;
	padding-bottom: 1px;
	padding-left: 5px;
}

.alignright {
	float: right;
	padding: 4px;
	font-weight: bold;
	padding-top: 10px;
	padding-right: 0px;
	padding-bottom: 1px;
	padding-left: 5px;
}

.top-icons .fa {
    width: 24px !important;
    height: 30px !important;
    border-radius: 8px !important;
    overflow-x: hidden;
    padding-top: 5px;
    font-size: 20px;
    margin-top: 5px;
}

.msg {
	border-bottom: 1px solid #ccc;
	background: #fff9c4 !important;
}

.msg p {
	font-weight: 300;
	padding: 10px;
}

.offerheading {
    font-size: .875rem;
    box-shadow: 0 -5px 5px rgba(0, 0, 0, .1);
    display: block !important;
    overflow: hidden;
    padding-top: 15px;
}

.offerheading a {
	color: #000;
	text-decoration: none !important;
}

.btn-blue,
.btn-blue:focus {
	background: #f6c733;
	color: #fff;
}

    </style>
    <link rel="stylesheet" href="https://markettradersdaily.com/live-event/1/webinar.css?<?php echo time();?>">
   <script>
       function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function eraseCookie(name) {   
            document.cookie = name+'=; Max-Age=-99999999;';  
        }

        //let sticky_messages = [{"key":"82694a8c-8df8-4b0b-98ff-927e87f415f6","message":"If you have any issues or questions throughout this webinar feel free to let us know here it the chat or call in 888-228-2376 or international 321-221-4574.","start":5,"end":2939},{"key":"7f796d89-a485-4b9a-afa0-cd72e13a8aeb","message":"Only 50 Packages Available at This Price!! Register at www.markettradersdaily.com\/yes. Use the coupon code \u0022now\u0022 to save $3000. You can also place your order over the phone 888-228-2376 or international 321-221-4574.","start":2940,"end":6597}];
        //let sticky_messages = [{"key":"82694a8c-8df8-4b0b-98ff-927e87f415f6","message":"The chat is in privatized mode so feel free to ask any question. Only the moderators can see so your privacy is protected. Feel free to call in with questions as well. 888-228-2376","start":20,"end":3305}]

         let sticky_messages = [{"key":"ac4eab03-81d6-4b7d-b536-ad23ad5b5036","message":"Join Anthony now using coupon code \u201c500off\u201d. Register at <a href='www.bigenergyprofits.com' target='_blank'>Link</a>\/go or phone your order to <a href:'tel:888-228-2376'>888-228-2376</a>","start":10,"end":4660}]

        //push all your messages here
        //sticky_messages.push({"key":"82694a8c-8df8-4b0b-98ff-927e87f415f6","message":"If you have any issues or questions throughout this webinar feel free to let us know here it the chat or call in 888-228-2376 or international 321-221-4574.","start":5,"end":2939},{"key":"7f796d89-a485-4b9a-afa0-cd72e13a8aeb","message":"Only 50 Packages Available at This Price!! Register at www.markettradersdaily.com\/yes. Use the coupon code \u0022now\u0022 to save $3000. You can also place your order over the phone 888-228-2376 or international 321-221-4574.","start":2940,"end":6597});
        var convertToMinutes = false;
        var running = 0;

        function runNotifications(sec){
            setCookie('videoTimer2', sec.seconds, 1);
            if(running < 1){
                running = running + 1;
                let statingArray = [];
                    sticky_messages.forEach(function(data, index){
                        var delayStart, delayEnd;
                        delayStart = (Number(data.start) - Number(sec.seconds)) * 1000;
                        delayEnd = data.end * 1000;
                        var intervalStart = setTimeout(()=>{
                            setCookie('chatTimerIndex', `${index}`, 1);
                            showNotification(data);
                        }, delayStart, index );
                        setTimeout( function(){
                            closeNotification(data);
                        }, delayEnd );
                    });
            }
        }
      function extractTime(time){
          var hour = time.toString().slice(0, 2);
          var minute = time.toString().slice(2, 4);
          return {minutes: hour, seconds: minute};
      }
      function showNotification(data){
        id ="noti-" + data.key
        $(".msg").append('<p class="items" id="'+id+'" style="display:none;" >'+data.message+'</p>');
        $('#'+id).show('slow')
      }
      function closeNotification(data){
          $("#noti-"+ data.key).remove();
      }
      </script>
</head>

<body>
   <div id="app">
    <div class="live-broadcast-container theme_1">
      <div class="main-container d-flex justify-content-between">
            <div class="top_content_wrapper w-100 d-flex justify-content-center p-relative">
                <div class="layout-renderer-container-attendee w-100 d-flex align-items-center justify-content-center p-relative">
                <div class="video-container" >
                    <img class="video-play-1"  src="ezgif.com-video-to-gif.gif" width="100%" />
                    <!-- <video controls src="https://d32jxcflrw1duz.cloudfront.net/IR-Booker.mp4"></video> -->
                    <iframe class="video_iframe_vm" src="https://player.vimeo.com/video/459760992?controls=0" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                    <script src="https://player.vimeo.com/api/player.js"></script>
                    <script>
                        $( document ).ready(function() {
                            $('.video_iframe_vm').hide();
                            var iframe = document.querySelector('iframe');
                            var player = new Vimeo.Player(iframe);
                            $('.offerfiv').hide();
                            $('.offerheading').hide();
                        
                        
                            let totalVideoDuration = undefined;
                            let startTime = 0;
                            let videoTimer = getCookie('videoTimer2');
                            let chatTimerIndex = getCookie('chatTimerIndex');
                        
                            player.getDuration().then(function(duration) {
                                console.log(duration)
                                totalVideoDuration = duration;
                        
                                
                                if(videoTimer && Number(videoTimer) < totalVideoDuration){
                                    startTime = Number(videoTimer);
                                    
                                    
                                }
                            });
                        
                            $('.video-play-1').on('click', function(e) {
                                $('.video_iframe_vm').show();
                                player.play();
                                player.setCurrentTime(startTime);             
                                e.preventDefault(); 
                                $('.video-play-1').hide();
                            });
                            
                        
                            player.on('timeupdate', function(sec) { 
                                runNotifications(sec);      
                                given_seconds = sec.seconds; 
                        
                                hours = Math.floor(given_seconds / 3600); 
                                minutes = Math.floor((given_seconds - (hours * 3600)) / 60); 
                                seconds = given_seconds - (hours * 3600) - (minutes * 60); 
                        
                                timeString = hours.toString().padStart(2, '0') + ':' + 
                                    minutes.toString().padStart(2, '0') + ':' + 
                                    Math.round(seconds).toString().padStart(2, '0'); 
                        
                        
                        
                            
                                $(".timers").html(timeString);
                                if(sec.seconds > 10) {
                                    
                                    $('.offerfiv').show();
                                    document.getElementById('timer').innerHTML = 59 + ":" + 00;
                                    startTimer();
                        
                                    function startTimer() {
                                        var presentTime = document.getElementById('timer').innerHTML;
                                        var timeArray = presentTime.split(/[:]+/);
                                        var m = timeArray[0];
                                        var s = checkSecond((timeArray[1] - 1));
                                        if(s==59){m=m-1}
                                        //if(m<0){alert('timer completed')}
                                        
                                        document.getElementById('timer').innerHTML =
                                            m + ":" + s;
                                        console.log(m)
                                        setTimeout(startTimer, 1000);
                                    }
                        
                                    function checkSecond(sec) {
                                        if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
                                        if (sec < 0) {sec = "59"};
                                        return sec;
                                    }
                        
                        
                                    $('.offers').show();
                                }
                        });
                        
                        });
                    </script>
                </div>
                <!-- <div class="d-flex z-index-101 justify-content-center p-relative live_content_wrapper_generic">
                    </div> -->
                </div>
            </div>   
            <div class="sidebar-container d-flex flex-grow-1 flex-grow-lg-0">               
               <div class="liveroom_sidebar h-100 p-relative with_handle">
                  <div class="liveroom_container d-flex flex-column flex-grow-1 h-100 w-100 p-relative for_attendee">
                     <div class="navbar navbar_dark px-3">
                        <div class="row top-icons w-full justify-content-between align-items-center text-center">
                           <div class="col">
                              <div class="label">
                                 <i class="fa fa-users"></i> 
                                 <p class="timer"></p>
                                 <script>
                                    (function($) {
                                    $.fn.countTo = function(options) {
                                    // merge the default plugin settings with the custom options
                                    options = $.extend({}, $.fn.countTo.defaults, options || {});
                                    
                                    // how many times to update the value, and how much to increment the value on each update
                                    var loops = Math.ceil(options.speed / options.refreshInterval),
                                    increment = (options.to - options.from) / loops;
                                    
                                    return $(this).each(function() {
                                    var _this = this,
                                    loopCount = 0,
                                    value = options.from,
                                    interval = setInterval(updateTimer, options.refreshInterval);
                                    
                                    function updateTimer() {
                                    value += increment;
                                    loopCount++;
                                    $(_this).html(value.toFixed(options.decimals));
                                    
                                    if (typeof(options.onUpdate) == 'function') {
                                    options.onUpdate.call(_this, value);
                                    }
                                    
                                    if (loopCount >= loops) {
                                    clearInterval(interval);
                                    value = options.to;
                                    
                                    if (typeof(options.onComplete) == 'function') {
                                    options.onComplete.call(_this, value);
                                    }
                                    }
                                    }
                                    });
                                    };
                                    
                                    $.fn.countTo.defaults = {
                                    from: 0,  // the number the element should start at
                                    to: 100,  // the number the element should end at
                                    speed: 1000,  // how long it should take to count between the target numbers
                                    refreshInterval: 100,  // how often the element should be updated
                                    decimals: 0,  // the number of decimal places to show
                                    onUpdate: null,  // callback method for every time the element is updated,
                                    onComplete: null,  // callback method for when the element finishes updating
                                    };
                                    })(jQuery);
                                    
                                    jQuery(function($) {
                                    $('.timer').countTo({
                                    from: 4000,
                                    to: 5000,
                                    speed: 5000000,
                                    refreshInterval: 3700,
                                    onComplete: function(value) {
                                    console.debug(this);
                                    }
                                    });
                                    });
                                 </script>
                              </div>
                           </div>
                           <div class="col">
                              <div class="label">
                                 <i class="fa fa-clock-o"></i> 
                                 <p class="timers">00:00:00</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="d-flex flex-grow-1 hidden_wrapper">
                        <div
                           class="liveroom_content w-full card card-sm no_border_radius tab-content tab-content-main">
                           <div class="msg">
                           </div>
                           <div class="offerfiv">
                              <p class="offerheading">
                                 <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="offer_txt">
                              <span class="offer_txt">Offers</span> <i class="fa fa-angle-down" aria-hidden="true"></i>

                              </a>
                              </p>
                              <div class="collapse show" id="collapseExample">
                                 <div class="card card-body">
                                    <!-- <div class="offer_exp"> 
                                       <p class="alignleft">Offer ends in </p>
                                       <p class="alignright" id="timer"> </p>
                                       
                                       </div> -->
                                       <div class="text-center offers" style=" ">
                                       <h5 class="mb-3 text-break">
                                       Click Here To Join the BEP Family
                                       </h5>
                                       <img src="https://bigenergyprofits.com/live-event/1/images/Presentation-Card.jpg" alt="Click Here To Join the BEP Family" class="w-100 mb-3"> 
                                    </div>
                                    <a href="https://bigenergyprofits.safechkout.net/BEP-Order" target="_blank" class="btn btn-db btn-rect btn-shadow btn-ns btn-blue d-block w-100 text-wrap text-break">
                                    Click To Get Started Today!
                                    </a>
                                 </div>
                              </div>                              
                           </div>
                           
                        </div>
                     </div>
                     <div class="side_footer" style="display:none;">
                                 <textarea placeholder="Type your question here..." class="form-control"></textarea>
                                 <a style="margin-top: 10px;" href="#" target="_blank" class="btn btn-db btn-rect btn-shadow btn-ns btn-blue d-block w-100 text-wrap text-break">
                                 Send Email
                                 </a> 
                              </div>
                  </div>
                  <button type="button" class="btn btn-db btn-expander-left pb_btn-expander-left px-0 l-0"><i
                  class="fa fa-ellipsis-v"></i>
               </button>
               </div>
            </div>
         
      </div>
    </div>  
   </div>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
   <script>
      $(document).ready(function () {
          $('.btn-expander-left').click(function () {
              if ($('body').hasClass('sidebar-show')) {
                  $('body').removeClass('sidebar-show');
              } else {
                  $('body').addClass('sidebar-show');
              }
          })
      })
   </script>
   <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '187804185085753');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=187804185085753&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script src='https://optassets.ontraport.com/tracking.js' type='text/javascript' async='true' onload='_mri="21828",_mr_domain="tracking.ontraport.com",mrtracking();'></script>
<!-- Global site tag (gtag.js) - Google AdWords: 1070781524 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1070781524"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1070781524');
</script>
<script type="text/javascript" src="https://widget.wickedreports.com/v2/602/wr-a2c20b58dba8a66cd3c2d4dca4c93a24.js" async></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-537465-21', 'auto');
  ga('send', 'pageview');

</script>
</body>

</html>
