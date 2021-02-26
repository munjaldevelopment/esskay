<div class="outer-bg">
	<div class="inner-bg" style="background: white !important;">
		<div class="container-fluid">  
			<section class="fxt-template-animation fxt-template-layout4">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 col-12 fxt-bg-wrap">
							<div class="fxt-bg-img" data-bg-image="{{ asset('public/') }}/{{ forgot_password_page_background }}">
		                        <div class="fxt-header">
		                            <div class="fxt-transformY-50 fxt-transition-delay-1 visibility-hidden">
		                                <a href="{{ asset('/')}}login" class="fxt-logo"><img src="{{ asset('public/') }}/{{ site_logo }}" alt="Logo"></a>
		                            </div>
		                            <div class="fxt-transformY-50 fxt-transition-delay-2 visibility-hidden">
		                                <h1>Welcome To EssKay</h1>
		                            </div>
									<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
										{!! forgot_password_page_content !!}
		                            </div>
		                        </div>
		                    </div>
						</div>
						
						<div class="col-md-6 col-12 fxt-bg-color">
							<div class="fxt-content">
								<div class="fxt-form">
									<h1>Contact Us</h1>
								
									<div class="contact-result"></div>
									
									<div class="form-group fname-container">  
										<!-- <label for="email" class="input-label">First Name</label> -->                                              
										<input type="text" id="first_name" class="form-control" name="first_name" placeholder="Your First Name" >
									</div>
									
									<div class="form-group lname-container">  
										<!-- <label for="email" class="input-label">Last Name</label> -->                                              
										<input type="text" id="last_name" class="form-control" name="last_name" placeholder="Your Last Name" >
									</div>
									
									<div class="form-group email-container">  
										<!-- <label for="email" class="input-label">Email Address</label> -->                                              
										<input type="email" required id="email" class="form-control" name="email" placeholder="Your Email" >
									</div>
									
									<div class="form-group telephone-container">  
										<!-- <label for="email" class="input-label">Telephone</label> -->                                              
										<input type="tel" required id="telephone" class="form-control" name="telephone" placeholder="Your Contact Number" >
									</div>
									
									<div class="form-group message-container">
										<!-- <label for="email" class="input-label">Message</label>  -->    
										<textarea required name="message" class="form-control" placeholder="Please enter your message" cols="5"></textarea>

									</div>
									
									<div class="form-group d-flex">
										<button type="button" class="fxt-btn-fill btn-contact">Submit</button>
									</div>
								</div> 
								<div class="fxt-footer">
								</div>                          
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<!-- Google Web Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/style_login.css">

<!-- Popper js -->
<script src="{{ asset('public/assets/') }}/js/popper.min.js"></script>
<!-- Imagesloaded js -->
<script src="{{ asset('public/assets/') }}/js/imagesloaded.pkgd.min.js"></script>
<!-- Validator js -->
<script src="{{ asset('public/assets/') }}/js/validator.min.js"></script>
<!-- Custom Js -->
<script src="{{ asset('public/assets/') }}/js/main.js"></script>

<style>
	.select2-container--default .select2-selection--single {
		border:none;
		border-bottom: 1px solid #e7e7e7;
		color: #111;
	}
	
	.select2-container .select2-selection--single .select2-selection__rendered {
		padding-left: 0;
	}
	
	.swal-text {
		font-size: 20px;
	}
	
	.register-result {
		color: #000000;
	}
	
	.fxt-template-layout4 .fxt-form .form-control {
		background: transparent;
	}
</style>

<script>
$(document).ready(function() {
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	
	$('.btn-contact').bind('click', function() {
		var first_name = $("input[name=first_name]").val();
		var last_name = $("input[name=last_name]").val();
		var email = $("input[name=email]").val();
		var telephone = $("input[name=telephone]").val();
		var message = $("textarea[name=message]").val();
		
		var error = 0;
		
		if(message == "")
		{
			swal({
				title: "",
				text: "Please enter message",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.fname-container').removeClass('has-error');
			$('.lname-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.message-container').addClass('has-error');
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
			
			$('.fname-container').removeClass('has-error');
			$('.lname-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.message-container').removeClass('has-error');
			$('.telephone-container').addClass('has-error');
		}
		
		if(email == "")
		{
			swal({
				title: "",
				text: "Please enter your email-address",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.fname-container').removeClass('has-error');
			$('.lname-container').removeClass('has-error');
			$('.message-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
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
				
				$('.fname-container').removeClass('has-error');
				$('.lname-container').removeClass('has-error');
				$('.message-container').removeClass('has-error');
				$('.telephone-container').removeClass('has-error');
				$('.email-container').addClass('has-error');
			}
		}
		
		if(last_name == "")
		{
			swal({
				title: "",
				text: "Please enter Last Name",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.fname-container').removeClass('has-error');
			$('.message-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.lname-container').addClass('has-error');
		}
		
		if(first_name == "")
		{
			swal({
				title: "",
				text: "Please enter First Name",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.lname-container').removeClass('has-error');
			$('.message-container').removeClass('has-error');
			$('.telephone-container').removeClass('has-error');
			$('.email-container').removeClass('has-error');
			$('.fname-container').addClass('has-error');
		}
		
		if(error == 0)
		{
			$.ajax({
				url: base_url+'saveContact',
				type: 'post',
				data: {first_name: first_name, last_name: last_name, email: email, telephone: telephone, message: message},
				beforeSend: function() {
				},
				success: function(output) {
					swal({
						title: "",
						text: "Thanks for contact with us. We will get back to you shortly.",
						icon: "success",
						button: "Ok",
					});
					
					$("input[name=first_name]").val('');
					$("input[name=last_name]").val('');
					$("input[name=email]").val('');
					$("input[name=telephone]").val('');
					$("textarea[name=message]").val('');
					
					//$('.contact-result').html(output);
				}
			});
		}
	});
});
</script>