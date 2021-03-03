@include('common.header_body')

<div class="preloader" style="display:none;"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>

<section class="custom-linear pt-3">
	@if($lenderData->is_banking_arrangement == 1)
	<div class="row-fluid">
		<div class="col-md-12">
			<h2> Loan Summary (In Cr.)</h2>
			<div class="swiper-viewport">
				<div id="carousel0" class="swiper-container">
					<div class="swiper-wrapper">
						@foreach($lenderBankingData as $k => $bdetail)
						<div class="swiper-slide text-center">
							<div class="row">
								<div class="col-md-12">
									<div class="card no-border">
										<div class="card-body">
											<td><span class="bg-blue-light" data-toggle="modal" data-target="#staticBackdrop">{!! $bdetail['banking_arrangment_name'] !!}</span></td>
											<td><span class="spn">Sanctioned: <br /> <i class="fa fa-inr" aria-hidden="true"></i> {!! $bdetail['sanction_amount'] !!}</span></td>
											<td><span class="spn spn-bdr">Outstanding: <br /> <i class="fa fa-inr" aria-hidden="true"></i> {!! $bdetail['outstanding_amount'] !!}</span></td>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				
				<div class="swiper-pagination carousel0"></div>
				<div class="swiper-pager">
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog loan-summry-modal">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="staticBackdropLabel">PTC (Investor Portion)</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true"><img src="{{ asset('public/assets/') }}/images/modal-close-icon.svg" alt=""></span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
						  <tr>
							<th>#</th>
							<th>Date</th>
							<th>Sanctioned (in Cr.)</th>
							<th>Outstanding (in Cr.)</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<td>1</td>
							<td>29 Jan 2021</td>
							<td><img src="{{ asset('public/assets/') }}/images/rupees-icon.svg" alt=""> 50,000</td>
							<td><img src="{{ asset('public/assets/') }}/images/rupees-icon.svg" alt=""> 10,000</td>
						  </tr>
						  <tr>
							<td>2</td>
							<td>28 Jan 2021</td>
							<td><img src="{{ asset('public/assets/') }}/images/rupees-icon.svg" alt=""> 40,000</td>
							<td><img src="{{ asset('public/assets/') }}/images/rupees-icon.svg" alt=""> 20,000</td>
						  </tr>
						</tbody>
					  </table>	
				</div>	
			</div>
	      </div>
	    </div>
	  </div>
	</div>	
	
	<div class="row-fluid mb-2">
		<div class="col-md-12">
			<hr />
		</div>
	</div>
	@endif
		
	<input type="hidden" id="is_message_md" class="is_message_md" value="{{ $lenderData->is_message_md }}" />
	<input type="hidden" id="is_document" class="is_document" value="{{ $lenderData->is_document }}" />
	<input type="hidden" id="is_financial_summary" class="is_financial_summary" value="{{ $lenderData->is_financial_summary }}" />
	<input type="hidden" id="is_newsletter" class="is_newsletter" value="{{ $lenderData->is_newsletter }}" />
	<input type="hidden" id="is_contact_us" class="is_contact_us" value="{{ $lenderData->is_contact_us }}" />
		
	<div class="main-tab-area">
		<div class="tab-top-area">
			<ul class="nav esskay-home">
				@if($lenderData->is_message_md == 1)
				<li class="nav-item">
					<!-- Single button -->
					<div class="dropdown">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							About Us
					  	</button>
					  	<div class="dropdown-menu">
							<a class="dropdown-item home-class active" href="javascript:;">Message from MD</a>
							<a class="dropdown-item board-class" href="javascript:;">Board of  Directors</a>
							<a class="dropdown-item key-manager-class" href="javascript:;">Key Managerial Person</a>
					  	</div>
					</div>
				</li>

				<li class="nav-item">
					<a class="nav-link insight-class " href="javascript:;">Insight</a>
				</li>
				@endif
				@if($lenderData->is_document == 1)
				<li class="nav-item">
					<a class="nav-link doc-class @if($lenderData->is_message_md == 0) active @endif" href="javascript:;">Documents</a>
				</li>
				@endif
				@if($lenderData->is_financial_summary == 1)
				<li class="nav-item">
				<a class="nav-link graph-class @if($lenderData->is_message_md == 0 && $lenderData->is_document == 0) active @endif" href="javascript:;">Financial Summary</a>
				</li>
				@endif
				@if($lenderData->is_newsletter == 1)
				<li class="nav-item">
				<a class="nav-link news-class @if($lenderData->is_message_md == 0 && $lenderData->is_document == 0 && $lenderData->is_financial_summary == 0) active @endif" href="javascript:;">Newsletters</a>
				</li>
				@endif
				@if($lenderData->is_contact_us == 1)
				<li class="nav-item">
				<a class="nav-link contact-class @if($lenderData->is_message_md == 0 && $lenderData->is_document == 0 && $lenderData->is_financial_summary == 0 && $lenderData->is_newsletter == 0) active @endif" href="javascript:;">Contact Us</a>
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
	.carousel-control-next, .carousel-control-prev {
		width: 2%;
	}
	
	.carousel-control-next-icon, .carousel-control-prev-icon {
		background-color:#58afe4;
	}
	
	.card.no-border {
		border:none;
	}
</style>
<script> 
$(document).ready(function(){
	$('#carousel0').swiper({
		mode: 'horizontal',
		@if($lenderCount > 2)
		slidesPerView: 4,
		@else
		slidesPerView: 1,
		@endif
		spaceBetween: 20,
		/*pagination: '.carousel0',*/
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		autoplay: false,
		loop: true,
		breakpoints: {
		    // when window width is >= 320px
		    320: {
		      slidesPerView: 2,
		      spaceBetween: 20
		    },
		    // when window width is >= 480px
		    480: {
		      slidesPerView: 1,
		      spaceBetween: 30
		    },
		    // when window width is >= 640px
		    640: {
		      slidesPerView: 2,
		      spaceBetween: 10
		    },
		     // when window width is >= 768px
		    768: {
		      slidesPerView: 3,
		      spaceBetween: 10
		    },
			
			1024: {
		      slidesPerView: 3,
		      spaceBetween: 10
		    }
		  }
	});
});
</script>
@include('common.footer_body')
