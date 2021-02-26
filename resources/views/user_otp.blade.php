@include('common.header_login')

<!--header end here-->
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->     
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
							<h1>User OTP</h1>
							
							@if (count($errors->login) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->login->all() as $error)
									<P>{{ $error }}</p>
									@endforeach
								</ul>
							</div>
							@endif 
							@if (Session::has('message'))
							<div class="alert alert-warning">{{ Session::get('message') }}</div>
							@endif
						
							<form class="log-in-form" action="{{ asset('/')}}saveUserOTP" method="post" name="loginForm">
								{{ csrf_field() }}
								
								<div class="form-group">  
                                    <label for="email" class="input-label">User OTP</label>                                              
                                    <input type="text" maxlength="6" required id="user_otp" class="form-control" name="user_otp" placeholder="Please enter OTP" >
                                </div>
								
								<div class="form-group">
									<button type="submit" class="fxt-btn-fill">Verify</button>
								</div>
							</form>
						</div> 
						<div class="fxt-footer">
                            <p>Don't have an account?<a href="{{ asset('/')}}register" class="switcher-text">Register</a></p>
                        </div>                          
                    </div>
                </div>
            </div>
        </div>
    </section>

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