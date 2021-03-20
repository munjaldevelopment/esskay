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

								<form class="log-in-form" action="{{ asset('/')}}saveUserOTP" method="post" name="loginForm">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="user-login-icon">   
												<i class="fa fa-envelope"></i>
												</div>
												<input type="text" maxlength="6" required id="user_otp" class="form-control" name="user_otp" placeholder="Please enter OTP">
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

@include('common.footer_body')