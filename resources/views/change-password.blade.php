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
                                <h1>Welcome to EssKay</h1>
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
							<h1>Update Password</h1>
							
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
						
							<form class="log-in-form" action="{{ asset('/')}}saveChangePassword" method="post" name="loginForm">
								{{ csrf_field() }}
								
								<div class="form-group userotp-container">  
                                    {{-- <label for="name" class="input-label"><span data-toggle="tooltip" data-placement="top" title="Please enter your name">User OTP*</span></label> --}}
									<input type="text" maxlength="6" required name="user_otp" class="form-control" placeholder="User OTP*">
								</div>
								
								<div class="form-group password-container">  
                                    {{--<label for="name" class="input-label"><span data-toggle="tooltip" data-placement="top" title="Please enter your name">Password*</span></label>--}}
									<input type="password" required name="password" class="form-control" placeholder="Password">
								</div>
								
								<div class="form-group confirm-container">  
                                    {{--<label for="name" class="input-label"><span data-toggle="tooltip" data-placement="top" title="Please enter your name">Confirm Password*</span></label>--}}
									<input type="password" required name="password_confirmation" class="form-control" placeholder="Confirm Password">
								</div>
								<div class="form-group d-flex">
									<button type="button" class="btn-change fxt-btn-fill">Submit</button>
								</div>
							</form>
						</div> 
						<div class="fxt-footer">
							<p>Already have account?<a href="{{ asset('/')}}login" class="switcher-text">Login</a></p>
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
