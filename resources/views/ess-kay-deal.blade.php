<div class="main-tab-details">
	<!-- Tab panes -->
	<div class="tab-content">
		 <div class="mtd-inner-box">
				<div class="mtd-inner">
					<div class="side-body side-body-full">
						<div class="deal-summary-area">
							<div class="deal-heading">Summary</div>
							<div class="deal-summary-box">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="deal-summary-inner">
											<div class="dsi-summary-amount">{{ $dealTotalData->total_amount }} <span>cr(s)</span></div>
											<div class="dsi-summary-pera">Amount to be raised</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="deal-summary-inner">
											<div class="dsi-summary-amount">{{ $dealTotalData->total }}</div>
											<div class="dsi-summary-pera">Live Deals</div>
										</div>
									</div>
								</div>
							</div>							
						</div>
						
						<div class="deal-filter-area">
							<div class="deal-filter-head">
								<div class="dfh-filter-left">
									<ul>
										<li>
											<a href=""><img src="{{ asset('public/assets/') }}/images/live-deal.svg" alt=""> LIVE DEALS</a>
										</li>
									</ul>
								</div>
								
								<div class="dfh-filter-right">
									<div class="dfh-right-count">Showing 1 -10 <span>of 10</span></div>										
									<div class="dfh-right-filter"><img src="{{ asset('public/assets/') }}/images/filter-icon.svg" alt=""> Filter</div>										
								</div>									
							</div>
							<div class="deal-filter-by">
								<div class="deal-filter-left">
									<div class="dfl-filter-text">
										<img src="{{ asset('public/assets/') }}/images/filter-icon.svg" alt="">Filter by
									</div>
									<div class="row">
										<div class="col-md-4 col-sm-12">
											<div class="dfl-filter-box">
												<div class="dfl-filter-search">
													<input type="text" class="form-control" placeholder="Client/Deal Name">
													<button type="button" class="dflfs-search-btn"><img src="{{ asset('public/assets/') }}/images/search-icon.svg" alt=""></button>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="dfl-filter-box">
												<div class="custom-dropi">
													<select>
														<option>Rating</option>																
														<option>1</option>																
														<option>2</option>																
														<option>3</option>																
														<option>4</option>																
														<option>5</option>																
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="dfl-filter-box">
												<div class="custom-dropi">
													<select>
														<option>Asset Class</option>																
														<option>Asset 1</option>																
														<option>Asset 2</option>																
														<option>Asset 3</option>																
														<option>Asset 4</option>																
														<option>Asset 5</option>																
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="deal-filter-right">
									<div class="deal-filter-right-sort">
										<img src="{{ asset('public/assets/') }}/images/sort-icon.svg" alt=""> Sort by
									</div>
									<div class="custom-dropi">
										<select>
											<option>Created On</option>																
											<option>Sort 1</option>																
											<option>Sort 2</option>																
											<option>Sort 3</option>																
											<option>Sort 4</option>																
											<option>Sort 5</option>																
										</select>
									</div>
								</div>
							</div>								
						</div>
						
						<div class="deal-list-area">
							<div class="well well-sm">
								<div class="deal-wall-left">
									<ul>
										<li class="active"><a href="">ALL</a></li>
										@foreach($dealCategoriesData as $row)
										<li><a href="javascript:;">{{ $row->category_name }}</a></li>
										@endforeach
									</ul>
								</div>
								<div class="btn-group">
									<a href="javascript:;" id="deal-grid" class="btn btn-default btn-sm">
										<img src="{{ asset('public/assets/') }}/images/grid-active-icon.svg" class="grid-icon deal-list-none" alt="">
									</a>
									<a href="javascript:;" id="deal-list" class="btn btn-default btn-sm">
										<img src="{{ asset('public/assets/') }}/images/list-icon.svg" class="list-icon deal-list-none" alt="">
									</a> 
								</div>
							</div>
							<div class="deal-products-area">
								<div class="deal-product-grid">
									<div class="row">
										@foreach($dealsData as $k => $row)
										<div class="col-md-4 col-sm-12">
											<div class="deal-product-box @if(($k % 3 == 1)) dpx-green @elseif(($k % 3 == 2)) dpx-yellow @endif">
												<div class="deal-product-category">
													<div class="dpc-cate-text">{{ $row->category_code }}</div>
												</div>
												<div class="deal-product-amount">{{ $row->amount }} Cr(s)</div>
												<div class="deal-product-bank">{{ $row->name }}</div>
												<div class="deal-product-info">
													<ul>
														<li>
															<div class="dpi-info-heading">Rating</div>
															<div class="dpi-info-details">{{ $row->rating }}</div>
														</li>
														<li>
															<div class="dpi-info-heading">Tenor</div>
															<div class="dpi-info-details">{{ $row->tenure }}</div>
														</li>
														<li>
															<div class="dpi-info-heading">Yield</div>
															<div class="dpi-info-details">{{ $row->pricing }}% fixed</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>	
<script> 
$(document).ready(function(){
	$('#carousel0').swiper({
		mode: 'horizontal',
		slidesPerView: 4,
		spaceBetween: 10,
		/*pagination: '.carousel0',*/
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		autoplay: 2500,
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
		      slidesPerView: 4,
		      spaceBetween: 10
		    }
		  }
	});
});
</script>	
	
<script>
	$(function () {
	    $('.navbar-toggle').click(function () {
	        $('.navbar-nav').toggleClass('slide-in');
	        $('.side-body').toggleClass('body-slide-in');
	        $('#search').removeClass('in').addClass('collapse').slideUp(200);

	        /// uncomment code for absolute positioning tweek see top comment in css
	        //$('.absolute-wrapper').toggleClass('slide-in');
	        
	    });
   
	   // Remove menu for searching
	   $('#search-trigger').click(function () {
	        $('.navbar-nav').removeClass('slide-in');
	        $('.side-body').removeClass('body-slide-in');

	        /// uncomment code for absolute positioning tweek see top comment in css
	        //$('.absolute-wrapper').removeClass('slide-in');

	    });

	  	$('.mtb_category_scroller').owlCarousel({
			margin: 10,
			loop: false,
			nav:true,
			navText: ["<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>","<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>"],  
			autoWidth: true,
			items: 4
		});

		$('#deal-grid').bind('click', function() {
			var base_url = $('base').attr('href');
	
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			$('.grid-icon').attr('src', '{{ asset('public/assets/') }}/images/grid-active-icon.svg');
			$('.list-icon').attr('src', '{{ asset('public/assets/') }}/images/list-icon.svg');

			$.ajax({
				url: base_url+'dealGrid',
				type: 'post',
				data: {_token: CSRF_TOKEN},
				beforeSend: function() {
					$('.preloader').show();
				},
				success: function(output) {
					$('.preloader').hide();
					$('.deal-products-area').html(output);
				}
			});
		});

		$('#deal-list').bind('click', function() {
			var base_url = $('base').attr('href');
	
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			$('.grid-icon').attr('src', '{{ asset('public/assets/') }}/images/grid-icon.svg');
			$('.list-icon').attr('src', '{{ asset('public/assets/') }}/images/list-active-icon.svg');

			$.ajax({
				url: base_url+'dealList',
				type: 'post',
				data: {_token: CSRF_TOKEN},
				beforeSend: function() {
					$('.preloader').show();
				},
				success: function(output) {
					$('.preloader').hide();
					$('.deal-products-area').html(output);
				}
			});
		});
	});
</script>