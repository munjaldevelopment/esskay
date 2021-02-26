@include('common.header_body')

<div class="preloader" style="display:none;"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>

<section class="custom-linear pt-3">

	<div class="container-fluid">
		<div class="row">
			<!-- <div class="col-md-1 col-2 logo-bar">
			</div> -->
			<div class="col-md-12">
				<div class="swiper-viewport">
					<div id="carousel0" class="swiper-container">
						<div class="swiper-wrapper">
							@foreach($lenderBankingData as $k => $bdetail)
							<div class="swiper-slide text-center">
								<div class="row">
									<div class="col-md-12">
										<div class="card no-border">
											<div class="card-body">
												<td><span class="bg-blue-light">{!! $bdetail['banking_arrangment_name'] !!}</span></td>
												<td><span class="spn"><i class="fa fa-inr" aria-hidden="true"></i> {!! $bdetail['sanction_amount'] !!}</span></td>
												<td><span class="spn spn-bdr"><i class="fa fa-inr" aria-hidden="true"></i> {!! $bdetail['outstanding_amount'] !!}</span></td>
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
		
		{{-- <div id="panel">
			<div class="panel-inside"> 
		 	@if(count($lenderBankingData)>0)
		 	<table class="table">
			  <thead>
			    <tr>
	    		  <th scope="col" class="theadin_tab">Name</th>
			      <th scope="col" class="theadin_tab">Amount</th>
			      <th scope="col" class="theadin_tab">Outstanding Amount</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($lenderBankingData as $k => $bdetail)
			    <tr>
			      <td>{!! $bdetail['banking_arrangment_name'] !!}</td>
			      <td>{!! $bdetail['sanction_amount'] !!}</td>
			      <td>{!! $bdetail['outstanding_amount'] !!}</td>
			    </tr>
			   @endforeach
			  </tbody>
			</table>
			@else
				<p>No detail found</p>
			@endif	
		</div>
		</div>	 --}}
		
		<div class="row mb-2">
			<div class="col-md-12">
				<hr />
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<ul class="nav custome-navbread esskay-home nav-tabs nav-pills">
					<li class="nav-item">
						<a class="nav-link home-class active" href="javascript:;">Message from MD / CXOs</a>
					</li>
					<li class="nav-item">
						<a class="nav-link doc-class" href="javascript:;">Documents</a>
					</li>
					<li class="nav-item">
					<a class="nav-link news-class" href="javascript:;">Newsletters</a>
					</li>
					<li class="nav-item">
					<a class="nav-link contact-class" href="javascript:;">Contact Us</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>


<section class="bg-white">
	<div class="pt-3 home-content">
		
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
		slidesPerView: 5,
		pagination: '.carousel0',
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		/*autoplay: 2500,*/
		loop: true
	});
});
</script>
@include('common.footer_body')
