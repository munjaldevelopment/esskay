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
					  We are happy to assist you for any query or request you may have. Just send the message by filling up the form and our team will get back to you.
					</p>
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
								 <a href=""><img src="{{ asset('public/') }}/{{ site_logo }}" alt=""></a>  
								</div>

            					<div class="contact-result"></div>


            					<div class="row">
									<div class="col-md-12">
										<div class="fname-container form-group">
											<div class="user-login-icon">   
											<i class="fa fa-envelope"></i>
											</div>
											<input type="text" id="first_name" class="form-control" name="first_name" placeholder="Your First Name">
										</div>  
									</div>  
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="lname-container form-group">
											<div class="user-login-icon">   
											<i class="fa fa-envelope"></i>
											</div>
											<input type="text" id="last_name" class="form-control" name="last_name" placeholder="Your Last Name">
										</div>  
									</div>  
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="email-container form-group">
											<div class="user-login-icon">   
											<i class="fa fa-envelope"></i>
											</div>
											<input type="email" required id="email" class="form-control" name="email" placeholder="Your Email">
										</div>  
									</div>  
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="telephone-container form-group">
											<div class="user-login-icon">   
											<i class="fa fa-envelope"></i>
											</div>
											<input type="tel" required id="telephone" maxlength="12" class="form-control" name="telephone" placeholder="Your Contact Number">
										</div>  
									</div>  
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="message-container form-group">
											<div class="user-login-icon">   
											<i class="fa fa-envelope"></i>
											</div>
											<textarea required id="class" class="form-control-textarea resize-none" name="class" placeholder="Enter message"></textarea>
										</div>  
									</div>  
								</div>

								<div class="row">  
									<div class="col-md-12">
										<div class="user-login-btn">
										<button type="button" class="custom-btn btn btn-contact"><i class="fa fa-sign-in" aria-hidden="true"></i> Submit</button>
										</div>
									</div>  
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
				url: base_url+'saveContactTrustee',
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