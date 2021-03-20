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
						<a class="btn" href="{{ asset('/')}}login"> Sign up</a>
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

								<form class="log-in-form" action="{{ asset('/')}}saveChangePassword" method="post" name="loginForm">
									{{ csrf_field() }}

									<div class="row">
										<div class="col-md-12">
											<div class="userotp-container form-group">
												<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>
												<input type="text" maxlength="6" required name="user_otp" class="form-control" placeholder="User OTP*">
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="password-container form-group">
												<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>
												<input type="password" required name="password" class="form-control" placeholder="Password">
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="confirm-container form-group">
												<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>
												<input type="password" required name="password_confirmation" class="form-control" placeholder="Confirm Password">
											</div>  
										</div>  
									</div>

									<div class="row">  
										<div class="col-md-12">
											<div class="user-login-btn">
											<button type="button" class="btn-change custom-btn btn fxt-btn-fill"><i class="fa fa-sign-in" aria-hidden="true"></i> Verify </button>
											</div>

											<p class="text-center">This site is protected by reCAPTCHA</p>

											<p class="text-center">Don't have an account?<a href="{{ asset('/')}}login" class="switcher-text">Register</a></p>
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

<!-- jquery-->
<script src="{{ asset('public/assets/') }}/js/jquery-3.5.0.min.js"></script>
<!-- Popper js -->
<script src="{{ asset('public/assets/') }}/js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="{{ asset('public/assets/') }}/js/bootstrap_login.min.js"></script>
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
</style>
<script>

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.btn-change').bind('click', function() {
		var name = $("input[name=user_otp]").val();
		var email = $("input[name=password]").val();
		var telephone = $("input[name=password_confirmation]").val();
		
		var error = 0;
		
		if(telephone == "")
		{
			swal({
				title: "",
				text: "Please enter confirm password",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.userotp-container').removeClass('has-error');
			$('.password-container').removeClass('has-error');
			$('.confirm-container').addClass('has-error');
		}
		
		if(email == "")
		{
			swal({
				title: "",
				text: "Please enter password",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.userotp-container').removeClass('has-error');
			$('.confirm-container').removeClass('has-error');
			$('.password-container').addClass('has-error');
		}
		
		if(email != telephone)
		{
			swal({
				title: "",
				text: "Password and confirm password not match",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.userotp-container').removeClass('has-error');
			$('.password-container').removeClass('has-error');
			$('.confirm-container').addClass('has-error');
		}
		
		if(name == "")
		{
			swal({
				title: "",
				text: "Please enter User OTP",
				icon: "warning",
				button: "Ok",
			});
			
			error = 1;
			
			$('.password-container').removeClass('has-error');
			$('.confirm-container').removeClass('has-error');
			$('.userotp-container').addClass('has-error');
		}
		
		var name = $("input[name=user_otp]").val();
		var email = $("input[name=password]").val();
		var telephone = $("input[name=password_confirmation]").val();
		
		if(error == 0)
		{
			$.ajax({
				url: base_url+'saveChangePassword',
				type: 'post',
				data: {user_otp: name, password: email},
				beforeSend: function() {
				},
				success: function(output) {
					if(output == 1)
					{
						swal({
							title: "",
							text: "Congratulations! Your password changed successfully.",
							icon: "success",
							button: "Ok",
						});
						
						setTimeout(function() {
							location = base_url+"login";
						}, 2000);
					}
					else
					{
						swal({
							title: "",
							content: {
								element: "p",
								attributes: {
									innerHTML: `${output}`
								}
							},
							icon: "warning",
							button: "Ok",
						});
					}
					//$('.register-result').html(output);
				}
			});
		}
	});
});
</script>

@include('common.footer_body')
