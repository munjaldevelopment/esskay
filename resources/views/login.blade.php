@include('common.header_login')
  
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

            					@if (count($errors->login) > 0)
								<div class="alert alert-danger">
								<ul>
								@foreach ($errors->login->all() as $error)
								{{ $error }}<br />
								@endforeach
								</ul>
								</div>
								@endif 
								@if (Session::has('message'))
								<div class="alert alert-warning">{{ Session::get('message') }}</div>
								@endif

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
												<i toggle="#password" class="fa fa-eye"></i>
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
											<a href="javascript:;" data-toggle="modal" data-target="#login_phone_modal">Login with Phone</a>
											</div>
										</div> 
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="forgot-password">
											<a href="javascript:;" data-toggle="modal" data-target="#forgot_modal">Forgot Password?</a>
											</div>
										</div> 
									</div>

									<div class="row">  
										<div class="col-md-12">
											<div class="checkbox">
												<label>
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

											<p class="text-center">This site is protected by reCAPTCHA</p>
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
											<div class="form-group name-container">
												<div class="user-login-icon">
												<i class="fa fa-user"></i>
												</div>
												<input type="text" required id="name" class="form-control" name="name" placeholder="Name">
											</div>
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="email-container form-group">
												<div class="user-login-icon">
												<i class="fa fa-envelope"></i>
												</div>
												<input type="email" required id="email" class="form-control" name="email" placeholder="Your Email Address">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
										<div class="telephone-container form-group">
										<div class="user-login-icon">   
										<i class="fa fa-phone-square"></i>
										</div>
										<input type="text" oninput="numberOnly(this.id);" id="telephone" required id="telephone" class="form-control" maxlength="10" name="telephone" placeholder="Phone">
										</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="organization-container form-group">
												<div class="user-login-icon">   
												<i class="fa fa-building"></i>
												</div>
												<input type="text" required id="organization" class="form-control" name="organization" placeholder="Organization">
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="designation-container form-group">
												<div class="user-login-icon">   
												<i class="fa fa-database"></i>
												</div>
												<input type="text" required id="designation" class="form-control" name="designation" placeholder="Designation">
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="message-container form-group textarea-user-icon">
												<div class="user-login-icon">   
												<i class="fa fa-comment"></i>
												</div>
												<textarea required id="message" class="form-control-textarea resize-none" name="message" placeholder="Enter message"></textarea>
											</div>
										</div>  
									</div>

									<div class="row">  
										<div class="col-md-12">
											<div class="checkbox">
												<label>
												<input type="checkbox" name="agree_signup" value="check" id="agree_signup" />
												<span class="cr"><i class="cr-icon fa fa-check"></i></span>
												<span class="check-content">I have read and agree to the <a href="{{ asset('/')}}uploads/page/terms-conditions.pdf" target="_blank">Terms and Conditions</a> & <a href="{{ asset('/')}}uploads/page/disclaimer.pdf" target="_blank">Disclaimer</a></span>
												</label>
											</div>
										</div>  
									</div>

									<div class="row">  
										<div class="col-md-12">
											<div class="user-login-btn">
											<button type="button" class="custom-btn btn btn-register"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign in</button>
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
					<form class="log-in-form" action="{{ asset('/')}}saveLoginOtp" method="post" name="loginForm">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="user-login-icon">   
									  <i class="fa fa-phone-square"></i>
									</div>
									<input type="tel" id="phone" class="form-control" name="phone" placeholder="Your Contact Number">
								</div>  
							</div>  
						</div>

						<div class="row">  
							<div class="col-md-12">
								<div class="checkbox">
									<label>
								  		<input type="checkbox" value="check" id="agree" name="agree" />
								 		<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								  		<span class="check-content">I have read and agree to the <a href="{{ asset('/')}}uploads/page/terms-conditions.pdf" target="_blank">Terms and Conditions</a> & <a href="{{ asset('/')}}uploads/page/disclaimer.pdf" target="_blank">Disclaimer</a></span>
									</label>
								</div>
							</div>  
						</div>

						<div class="row">  
							<div class="col-md-12">
								<div class="user-login-btn">
									<button button type="submit" class="custom-btn btn"><i class="fa fa-sign-in" aria-hidden="true"></i> Log in</button>
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
					<form class="log-in-form" action="{{ asset('/')}}saveForgotPhone" method="post" name="loginForm">
						{{ csrf_field() }}
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div class="user-login-icon">   
										<i class="fa fa-phone-square"></i>
										</div>
										<input type="text" oninput="numberOnly(this.id);" id="telephone" maxlength="10" required id="phone" class="form-control" name="phone" placeholder="Your Contact Number">
									</div>  
								</div>  
							</div>  

							<div class="row">  
								<div class="col-md-12">
								<div class="checkbox">
								<label>
								<input type="checkbox" checked value="">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<span class="check-content">I have read and agree to the <a href="">Terms and Conditions</a> &amp; <a href="">Disclaimer</a></span>
								</label>
								</div>
								</div>  
							</div>

							<div class="row">  
								<div class="col-md-12">
									<div class="user-login-btn">
									<button type="submit" class="custom-btn btn"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</button>
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


<script>
	function numberOnly(id) {
	    // Get element by id which passed as parameter within HTML element event
	    var element = document.getElementById(id);
	    // Use numbers only pattern, from 0 to 9
	    var regex = /[^0-9]/gi;
	    // This removes any other character but numbers as entered by user
	    element.value = element.value.replace(regex, "");
	}

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.btn-register').bind('click', function() {
		var name = $("input[name=name]").val();
		var email = $("input[name=email]").val();
		var telephone = $("input[name=telephone]").val();
		var organization = $("input[name=organization]").val();
		var designation = $("input[name=designation]").val();
		var message = $("textarea[name=message]").val();
		var agree = $("input[name=agree_signup]").prop("checked");
		//alert(agree);
		
		var error = 0;
		
		if(agree == false)
		{
			swal({
				title: "",
				text: "Please accept terms and conditions",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
		}
		
		if(message == "")
		{
			swal({
				title: "",
				text: "Please enter message",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.name-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.organization-container').removeClass('has-error');
			$('.designation-container').removeClass('has-error');
			$('.message-container').addClass('has-error');
		}
		
		if(designation == "")
		{
			swal({
				title: "",
				text: "Please enter designation",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.name-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.organization-container').removeClass('has-error');
			$('.designation-container').addClass('has-error');
		}
		
		if(organization == "")
		{
			swal({
				title: "",
				text: "Please enter organization name",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.name-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.organization-container').addClass('has-error');
		}
		
		if(telephone == "")
		{
			swal({
				title: "",
				text: "Please enter telephone number",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.name-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.telephone-container').addClass('has-error');
		}
		
		if(email == "")
		{
			swal({
				title: "",
				text: "Please enter email-address",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.name-container').removeClass('has-error');
			$('.email-container').addClass('has-error');
		}
		else
		{
			var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
			if(!pattern.test(email))
			{
				swal({
					title: "",
					text: "Please enter valid email-address",
					icon: "warning",
					button: "Ok",
				});
				
				error = 1;
				
				$('.name-container').removeClass('has-error');
				$('.email-container').addClass('has-error');
			}
		}
		
		
		if(name == "")
		{
			swal({
				title: "",
				text: "Please enter name",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.email-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.organization-container').removeClass('has-error');
			$('.designation-container').removeClass('has-error');
			$('.message-container').removeClass('has-error');
			$('.name-container').addClass('has-error');
			
			
		}
		
		var name = $("input[name=name]").val();
		var email = $("input[name=email]").val();
		var telephone = $("input[name=telephone]").val();
		var organization = $("input[name=organization]").val();
		var designation = $("input[name=designation]").val();
		var message = $("textarea[name=message]").val();

		
		if(error == 0)
		{
			if(document.getElementById('agree_signup').checked) {
				$.ajax({
					url: base_url+'saveRegister',
					type: 'post',
					data: {name: name, email: email, telephone: telephone, organization: organization, designation: designation, message: message},
					beforeSend: function() {
					},
					success: function(output) {
						swal({
							title: "",
							text: "Thanks for registering with us. We will get back to you shortly.",
							icon: "success",
							button: "Ok",
						});
						
						$("input[name=name]").val('');
						$("input[name=email]").val('');
						$("input[name=telephone]").val('');
						$("input[name=organization]").val('');
						$("input[name=designation]").val('');
						$("textarea[name=message]").val('');
							
						//$('.register-result').html(output);
					}
				});
			} else { 
				swal({
					title: "",
					text: "Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy",
					icon: "warning",
					button: "Ok",
				});
				
				 return false;
			}
		}
	});
});
</script>

@include('common.footer_body')
