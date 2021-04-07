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
								 <a href=""><img src="{{ asset('public/') }}/{{ site_logo }}" alt=""></a>  
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

								<form class="log-in-form" action="{{ asset('/')}}updatePassword" method="post" name="loginForm">
									{{ csrf_field() }}

									<input type="hidden" name="current_user_id" value="{{ $current_user_id }}">

									<div class="row">
										<div class="col-md-12">
											<div class="userotp-container form-group">
												<!--<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>-->
												<input type="text" maxlength="6" required name="user_otp" class="form-control" placeholder="User OTP*">
												<a href="javascript:;" class="fxt-btn-fill send-otp float-right">Send OTP</a>
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="password-container form-group">
												<!--<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>-->
												<input type="password" required name="password" readonly="" class="user-password form-control" placeholder="Password">
											</div>  
										</div>  
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="confirm-container form-group">
												<!--<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>-->
												<input type="password" required name="password_confirmation" readonly="" class="user-password form-control" placeholder="Confirm  Password">
											</div>  
										</div>  
									</div>

									<div class="row">  
										<div class="col-md-12">
											<div class="user-login-btn change-passowrd">
												<button disabled type="button" class="btn-change submit-btn custom-btn1 btn fxt-btn-fill"><i class="fa fa-sign-in d-none hide" aria-hidden="true"></i> Verify </button>
												<a href="{{ asset('/')}}" class="custom-btn1 btn fxt-btn-fill">Back</a>
											</div>
										</div>
									</div>

									<div class="row">  
										<div class="col-md-12">
											<p class="text-center">This site is protected by reCAPTCHA</p>

											<!--<p class="text-center">Don't have an account?<a href="{{ asset('/')}}" class="switcher-text">Register</a></p>-->
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
	a.fxt-btn-fill.float-right {
    	position: relative;
        top: -35px;
	    right: -28%;
	}
</style>
<script>

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.send-otp').bind('click', function() {
		$.ajax({
			url: base_url+'send-user-otp',
			type: 'get',
			beforeSend: function() {
			},
			success: function(output) {
				$('.submit-btn').removeAttr('disabled');
				$('.user-password').removeAttr('readonly');
				$('.send-otp').html('Resend OTP');
			}
		});
	});
	
	$('.btn-change').bind('click', function() {
		var current_user_id = $("input[name=current_user_id]").val();
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
				url: base_url+'updatePassword',
				type: 'post',
				data: {current_user_id: current_user_id, user_otp: name, password: email},
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
							location = base_url;
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
