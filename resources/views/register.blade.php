@include('common.header_login')

<!--header end here-->
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade browser</a> to improve experience.</p>
    <![endif]-->     
    <section class="fxt-template-animation fxt-template-layout4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12 fxt-bg-wrap">
					<div class="fxt-bg-img" data-bg-image="{{ asset('public/') }}/{{ register_page_background }}">
                        <div class="fxt-header">
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
                            <div class="fxt-transformY-50 fxt-transition-delay-1 visibility-hidden">
                                <a href="{{ asset('/')}}register" class="fxt-logo"><img src="{{ asset('public/') }}/{{ site_logo }}" alt="Logo"></a>
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-2 visibility-hidden">
                                <h1>Welcome to EssKay</h1>
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
							<div class="fxt-transformY-50 fxt-transition-delay-3 visibility-hidden">
								{!! register_page_content !!}
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6 col-12 fxt-bg-color">
                    <div class="fxt-content">
                        <div class="fxt-form">
							<h1>Register Page</h1>
							
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
							
							<div class="register-result"></div>
						
							<form class="log-in-form" action="{{ asset('/')}}saveUserOTP" method="post" name="loginForm" >

								{{ csrf_field() }}
								
								<div class="form-group name-container">  
                                    <!-- <label for="name" class="input-label"><span data-toggle="tooltip" data-placement="top" title="Please enter name">Name*</span></label> -->
                                    <input type="text" required id="name" class="form-control" name="name" placeholder="Name" >
                                </div>
								
								<div class="form-group email-container">  
                                    <!-- <label for="email" class="input-label"><span data-toggle="tooltip" data-placement="top" title="Please enter email address">Email Address*</span></label> -->                                              
                                    <input type="email" required id="email" class="form-control" name="email" placeholder="Email" >
                                </div>
								
								<div class="form-group telephone-container">  
                                    <!-- <label for="email" class="input-label">Telephone*</label> -->                                              
                                    <input type="text" oninput="numberOnly(this.id);" id="telephone" required id="telephone" class="form-control" maxlength="10" name="telephone" placeholder="Phone Number" >
                                </div>
								
								<div class="form-group organization-container">  
                                    <!-- <label for="email" class="input-label">Organization*</label> -->                                              
                                    <input type="text" required id="organization" class="form-control" name="organization" placeholder="Organization" >
                                </div>
								
								<div class="form-group designation-container">  
                                    <!-- <label for="email" class="input-label">Designation*</label> -->      
									<input type="text" required id="designation" class="form-control" name="designation" placeholder="Designation" >
                                    {{--<select required id="designation" class="form-control select2" name="designation">
										<option value="CEO">CEO</option>
										<option value="CFO">CFO</option>
										<option value="CDO">CDO</option>
										<option value="CLO">CLO</option>
										<option value="CTO">CTO</option>
										<option value="COO">COO</option>
										<option value="CMO">CMO</option>
										<option value="Senior Project Manager">Senior Project Manager</option>
										<option value="Project Manager">Project Manager</option>
										<option value="Assistant Project Manager">Assistant Project Manager</option>
										<option value="Business Analyst">Business Analyst</option>
										<option value="Investor Relationship Manager">Investor Relationship Manager</option>
										<option value="Relationship Manager">Relationship Manager</option>
										<option value="Business Development Executive">Business Development Executive</option>
										<option value="Others">Others</option>
									</select>--}}
                                </div>
								
								<div class="form-group message-container">  
                                    <!-- <label for="email" class="input-label">Message*</label> -->                                              
                                    <textarea required id="message" class="form-control resize-none" name="message" placeholder="Enter message"></textarea>
                                </div>
								<div class="form-group message-container"> 
									<input type="checkbox" name="agree" value="check" id="agree" /> I have read and agree to the <a href="{{ asset('/')}}uploads/page/terms-conditions.pdf" target="_blank">Terms and Conditions</a> & <a href="{{ asset('/')}}uploads/page/disclaimer.pdf" target="_blank">Disclaimer</a>>
								</div>	

								<div class="form-group d-flex">
									<button type="button" class="fxt-btn-fill btn-register">Submit</button>
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

    <!-- Modal -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="termsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{!! $termsTitle !!}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! $termsContent !!}
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div> -->
    </div>
  </div>
</div>

<div class="modal fade" id="disclaimer" tabindex="-1" role="dialog" aria-labelledby="disclaimerTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{!! $disclaimerTitle !!}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! $disclaimerContent !!}
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div> -->
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
	function numberOnly(id) {
	    // Get element by id which passed as parameter within HTML element event
	    var element = document.getElementById(id);
	    // Use numbers only pattern, from 0 to 9
	    var regex = /[^0-9]/gi;
	    // This removes any other character but numbers as entered by user
	    element.value = element.value.replace(regex, "");
	}

$(document).ready(function() {
	$('.select2').select2();
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.btn-register').bind('click', function() {
		var name = $("input[name=name]").val();
		var email = $("input[name=email]").val();
		var telephone = $("input[name=telephone]").val();
		var organization = $("input[name=organization]").val();
		var designation = $("input[name=designation]").val();
		var message = $("textarea[name=message]").val();
		var agree = $("input[name=agree]").prop("checked");
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
			if(document.getElementById('agree').checked) {
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
