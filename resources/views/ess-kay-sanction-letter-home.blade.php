@include('common.header_sanction_letter_body')

<div class="preloader" style="display:none;"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>

<section class="custom-linear pt-3">
	<input type="hidden" id="is_sanction_letter" class="is_sanction_letter" value="{{ $trusteeData->is_sanction_letter }}" />
	<input type="hidden" id="is_contact_us" class="is_contact_us" value="{{ $trusteeData->is_contact_us }}" />
		
	<div class="main-tab-area">
		<div class="tab-top-area d-lg-block d-sm-none d-none">
			<ul class="nav esskay-home">
				@if($trusteeData->is_sanction_letter == 1)
				<li class="nav-item">
					<a class="nav-link sanction-letter-class active" href="javascript:;">Sanction Letter</a>
				</li>
				@endif
				
				@if($trusteeData->is_contact_us == 1)
				<li class="nav-item">
				<a class="nav-link contact-class @if($trusteeData->is_sanction_letter == 0) active @endif" href="javascript:;">Contact Us</a>
				</li>
				@endif

				
			</ul>
		</div>
	
		<div class="main-tab-details">
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="home-content">
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.card.no-border {
		border:none;
	}
</style>
<script> 

	$('.dropdown-sanction_letter').hover(function(){ 
  		//$('.dropdown-toggle', this).trigger('click'); 
	});

	$(document).ready(function(){
	});
</script>
@include('common.footer_sanction_letter_body')
