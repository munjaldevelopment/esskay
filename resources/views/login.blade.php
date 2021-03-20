@include('common.header_login')

<!--header end here-->
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->     
<div class="login-main-area">
  <div class="login_container">
    <div class="container-forms">
    <div class="container-info">
      <div class="info-item info-item-login">
      <div class="login_container_table">
        <div class="login_container_table-cell">
        <p>
          Already have account?
        </p>
        <div class="switch-btn btn">
          Log in
        </div>
        </div>
      </div>
      </div>
      <div class="info-item info-item-signup">
      <div class="login_container_table">
        <div class="login_container_table-cell">
        <p>
          Don't have an account?
        </p>
        <div class="switch-btn btn">
          Sign up
        </div>
        </div>
      </div>
      </div>
    </div>
    <div class="container-form">
      <div class="form-item log-in">
      <div class="login_container_table">
        <div class="login_container_table-cell">
          <div class="login-main-box">
            <div class="login-logo">
             <a href=""><img src="{{ asset('public/assets/') }}/images/sk-logo.png" alt=""></a>  
            </div>
            <form class="log-in-form" action="{{ asset('/')}}saveLogin" method="post" name="loginForm">
                {{ csrf_field() }}
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-envelope"></i>
                  </div>
                  <input type="email" id="email" class="form-control" name="email" placeholder="Your Email Address">
                 </div>  
               </div>  
              </div>  

              <div class="row">  
               <div class="col-md-12">
                 <div class="form-group password-login-box">
                  <div class="user-login-icon">   
                    <i class="fa fa-key"></i>
                  </div>
                  <input id="password" type="password" class="form-control" name="password" placeholder="Your Password">
                   <div class="user-password-icon">   
                    <i class="fa fa-eye"></i>
                  </div>
                 </div>  
               </div> 
              </div>

              <input type="hidden" name="recaptcha" id="recaptcha">
              <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
              <script>
                       grecaptcha.ready(function() {
                           grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: "login"}).then(function(token) {

                              if (token) {
                                document.getElementById('recaptcha').value = token;
                              }
                           });
                       });
              </script>

              <div class="row login-phone-row">  
               <div class="col-md-6 col-sm-6 col-xs-6">
                 <div class="login-phone">
                  <a href="" data-toggle="modal" data-target="#login_phone_modal">Login with Phone</a>
                 </div>
               </div> 
                <div class="col-md-6 col-sm-6 col-xs-6">
                 <div class="forgot-password">
                  <a href="" data-toggle="modal" data-target="#forgot_modal">Forgot Password?</a>
                 </div>
               </div> 
              </div>

              <div class="row">  
               <div class="col-md-12">
                 <div class="checkbox">
                  <label>
                    <input type="checkbox" value="">
                    <span class="cr"><input type="checkbox" value="check" id="agree" name="agree" /></span>
                    <span class="check-content">I have read and agree to the <a href="{{ asset('/')}}uploads/page/terms-conditions.pdf" target="_blank">Terms and Conditions</a> & <a href="{{ asset('/')}}uploads/page/disclaimer.pdf" target="_blank">Disclaimer</a></span>
                  </label>
                </div>
               </div>  
              </div>

              <div class="row">  
               <div class="col-md-12">
                 <div class="user-login-btn">
                   <button type="submit" class="custom-btn btn"><i class="fa fa-sign-in" aria-hidden="true"></i> Log in</button>
                 </div>

                 <p>This site is protected by reCAPTCHA</p>
               </div>  
              </div>

            </form>
          </div>
        </div>
      </div>
      </div>
      <div class="form-item sign-up">
      <div class="login_container_table">
        <div class="login_container_table-cell">
        <div class="login-main-box hover_scroll">
            <div class="login-logo">
             <a href=""><img src="{{ asset('public/assets/') }}/images/sk-logo.png" alt=""></a>  
            </div>
            <form class="log-in-form" action="{{ asset('/')}}saveUserOTP" method="post" name="loginForm" >

                {{ csrf_field() }}
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Name">
                 </div>  
               </div>  
              </div>
              
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-envelope"></i>
                  </div>
                  <input type="email" class="form-control" placeholder="Your Email Address">
                 </div>  
               </div>  
              </div>
              
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-phone-square"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Phone">
                 </div>  
               </div>  
              </div>
              
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-building"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Organization">
                 </div>  
               </div>  
              </div>
              
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                  <div class="user-login-icon">   
                    <i class="fa fa-database"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Designation">
                 </div>  
               </div>  
              </div>
              
              <div class="row">
               <div class="col-md-12">
                 <div class="form-group textarea-user-icon">
                  <div class="user-login-icon">   
                    <i class="fa fa-comment"></i>
                  </div>
                  <textarea class="form-control-textarea" placeholder="Enter message"></textarea>
                 </div>  
               </div>  
              </div>

              <div class="row">  
               <div class="col-md-12">
                 <div class="checkbox">
                  <label>
                    <input type="checkbox" value="">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    <span class="check-content">I have read and agree to the <a href="">Terms and Conditions</a> & <a href="">Disclaimer</a></span>
                  </label>
                </div>
               </div>  
              </div>

              <div class="row">  
               <div class="col-md-12">
                 <div class="user-login-btn">
                   <button type="button" class="custom-btn btn"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign in</button>
                 </div>
               </div>  
              </div>

            </form>
          </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>    
</div>
  

<!-- login with phone modal start -->
<div class="modal fade" id="login_phone_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">   
    <div class="modal-dialog loan-summry-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login with Phone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><img src="{{ asset('public/assets/') }}/images/modal-close-icon.svg" alt=""></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login-main-box">
      <form action="">
        <div class="row">
         <div class="col-md-12">
           <div class="form-group">
            <div class="user-login-icon">   
              <i class="fa fa-phone-square"></i>
            </div>
            <input type="phone" class="form-control" placeholder="Your Contact Number">
           </div>  
         </div>  
        </div>  

        <div class="row">  
         <div class="col-md-12">
           <div class="checkbox">
            <label>
              <input type="checkbox" value="">
              <span class="cr"><i class="cr-icon fa fa-check"></i></span>
              <span class="check-content">I have read and agree to the <a href="">Terms and Conditions</a> &amp; <a href="">Disclaimer</a></span>
            </label>
          </div>
         </div>  
        </div>

        <div class="row">  
         <div class="col-md-12">
           <div class="user-login-btn">
             <button type="button" class="custom-btn btn"><i class="fa fa-sign-in" aria-hidden="true"></i> Log in</button>
           </div>
         </div>  
        </div>

      </form>
    </div>
      </div>
    </div>
  </div>
  </div>  
<!-- login with phone modal end --> 

<!-- Forgot modal start --> 
<div class="modal fade" id="forgot_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">    
    <div class="modal-dialog loan-summry-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Forgot Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><img src="{{ asset('public/assets/') }}/images/modal-close-icon.svg" alt=""></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login-main-box">
      <form action="">
        <div class="row">
         <div class="col-md-12">
           <div class="form-group">
            <div class="user-login-icon">   
              <i class="fa fa-phone-square"></i>
            </div>
            <input type="phone" class="form-control" placeholder="Your Contact Number">
           </div>  
         </div>  
        </div>  

        <div class="row">  
         <div class="col-md-12">
           <div class="checkbox">
            <label>
              <input type="checkbox" value="">
              <span class="cr"><i class="cr-icon fa fa-check"></i></span>
              <span class="check-content">I have read and agree to the <a href="">Terms and Conditions</a> &amp; <a href="">Disclaimer</a></span>
            </label>
          </div>
         </div>  
        </div>

        <div class="row">  
         <div class="col-md-12">
           <div class="user-login-btn">
             <button type="button" class="custom-btn btn"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</button>
           </div>
         </div>  
        </div>

      </form>
    </div>
      </div>
    </div>
  </div>
  </div>  
<!-- Forgot modal end -->   

<!-- jquery-->
<script src="{{ asset('public/assets/') }}/js/jquery-3.5.0.min.js"></script>
<!-- Popper js -->
<script src="{{ asset('public/assets/') }}/js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="{{ asset('public/assets/') }}/js/bootstrap_login.min.js"></script>
<!-- Imagesloaded js -->
<script src="{{ asset('public/assets/') }}/js/custom.js"></script>

<script src="{{ asset('public/assets/') }}/js/imagesloaded.pkgd.min.js"></script>
<!-- Validator js -->
<script src="{{ asset('public/assets/') }}/js/validator.min.js"></script>
<!-- Custom Js -->
<script src="{{ asset('public/assets/') }}/js/main.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
</script>


<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>  
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>  
<script> 
$(document).ready(function(){
  $('#carousel0').swiper({
    mode: 'horizontal',
    slidesPerView: 4,
    spaceBetween: 10,
    /*pagination: '.carousel0',*/
    paginationClickable: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    autoplay: 2500,
    loop: true,
    breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 2,
          spaceBetween: 20
        },
        // when window width is >= 480px
        480: {
          slidesPerView: 1,
          spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 2,
          spaceBetween: 10
        },
         // when window width is >= 768px
        768: {
          slidesPerView: 3,
          spaceBetween: 10
        },
      
      1024: {
          slidesPerView: 4,
          spaceBetween: 10
        }
      }
  });
});
</script> 
  
<script>
  $(function () {
    $('.navbar-toggle').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').toggleClass('slide-in');
        
    });
   
   // Remove menu for searching
   $('#search-trigger').click(function () {
        $('.navbar-nav').removeClass('slide-in');
        $('.side-body').removeClass('body-slide-in');

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').removeClass('slide-in');

    });
    
  (function($){
    $(window).on("load",function(){       
      $("#content-1").mCustomScrollbar({
        theme:"minimal",
        scrollInertia: 60,
      });       
    });
  })(jQuery);
    
  (function($){
    $(window).on("load",function(){       
      $(".hover_scroll").mCustomScrollbar({
        theme:"minimal",
        scrollInertia: 60,
      });       
    });
  })(jQuery); 
    

$(document).ready(function() {
  $('.mtb_category_scroller').owlCarousel({
  margin: 10,
  loop: false,
  nav:true,
  navText: ["<img src='images/scroll-arrow.svg'>","<img src='images/scroll-arrow.svg'>"],  
  autoWidth: true,
  items: 4
  })
})  
    
/*sk video start*/
$("#sk_video1").click(function () {
    $("#sk_video_cont").hide();
    $("#sk_frame1")[0].src += "?autoplay=1";
    setTimeout(function(){ $("#sk_frame1").show(); }, 200);
});
/*sk video end*/  

    
$(".info-item .btn").click(function(){
  $(".login_container").toggleClass("log-in");
}); 
    
});
</script>


@include('common.footer_body')
