@include('common.header_login')

<!--header end here-->
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->     
    <section class="fxt-template-animation fxt-template-layout4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12 fxt-bg-wrap">
                    <div class="fxt-bg-img" data-bg-image="{{ asset('public/') }}/{{ login_page_background }}">
                        <div class="fxt-header">
                            <div class="fxt-transformY-50 fxt-transition-delay-1 visibility-hidden">
                                <a href="{{ asset('/')}}login" class="fxt-logo"><img src="{{ asset('public/') }}/{{ site_logo }}" alt="Logo"></a>
                            </div>
                            <div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-2 visibility-hidden">
                                <h1>Welcome to EssKay</h1>
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! login_page_content !!}
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6 col-12 fxt-bg-color">
					
                    <div class="fxt-content">
                        <div class="fxt-form">
							<h1>Log In</h1>
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
							
							<form class="log-in-form" action="{{ asset('/')}}saveLoginOtp" method="post" name="loginForm">
								{{ csrf_field() }}
								
                                <div class="form-group">  
                                    <!-- <label for="phone" class="input-label">Phone</label> -->                                              
                                    <input type="tel" id="phone" class="form-control" name="phone" placeholder="Your Contact Number" >
                                </div>
								
								
                                <div class="form-group">
                                    <div class="fxt-checkbox-area">
                                        <a href="{{ asset('/')}}forgot-password-phone" class="switcher-text text-right">Forgot Password</a>
                                    </div>
                                </div>
								<div class="form-group message-container"> 
                                    <input type="checkbox" value="check" id="agree" name="agree" /> I have read and agree to the <a href="{{ asset('/')}}uploads/page/terms-conditions.pdf" target="_blank">Terms and Conditions</a> & <a href="{{ asset('/')}}uploads/page/disclaimer.pdf" target="_blank">Disclaimer</a>
                                </div>
                                <div class="form-group d-flex">
                                    <button type="submit" class="fxt-btn-fill">Log in</button>
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

<script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
</script>

@include('common.footer_body')
