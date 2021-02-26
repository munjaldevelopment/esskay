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
                            <div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								Test {!! forgot_password_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-2 visibility-hidden">
                                <h1>Welcome to EssKay</h1>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6 col-12 fxt-bg-color">
                    <div class="fxt-content">
                        <div class="fxt-form">
							<h1>Forgot Password</h1>
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
						
							<form class="log-in-form" action="{{ asset('/')}}saveForgotPhone" method="post" name="loginForm">
								{{ csrf_field() }}
								
								<div class="form-group">  
                                    <!-- <label for="email" class="input-label">Email Address</label> -->                                              
                                    <input type="text" oninput="numberOnly(this.id);" id="telephone" maxlength="10" required id="phone" class="form-control" name="phone" placeholder="Your Phone Number" >
                                </div>
								
								<div class="form-group">
                                    <div class="fxt-checkbox-area">
                                        <p class="already-account">Already have account?<a href="{{ asset('/')}}login" class="switcher-text text-right">Login</a></p>
                                    </div>
                                </div>
								
								<div class="form-group d-flex">
                                    <button type="submit" class="fxt-btn-fill">Change Password</button>
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
    function numberOnly(id) {
        // Get element by id which passed as parameter within HTML element event
        var element = document.getElementById(id);
        // Use numbers only pattern, from 0 to 9
        var regex = /[^0-9]/gi;
        // This removes any other character but numbers as entered by user
        element.value = element.value.replace(regex, "");
    }
</script>
@include('common.footer_body')
