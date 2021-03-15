<div class="main-tab-details">
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="mtd-inner-box">
			<div class="mtd-inner">
				 <!-- Menu -->
				<div class="side-menu"  id="content-1">
					<nav class="navbar" role="navigation">

						<!-- Main Menu -->
						<div class="side-menu-container">
							<ul class="nav navbar-nav" id="menu-accordian">
								@if($transactionLiveData)
								<li class="panel panel-default" id="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvl2">
										<span><img src="{{ asset('public/assets/') }}/images/live-icon.svg" alt=""></span> Live <span class="caret-icon"><img src="{{ asset('public/assets/') }}/images/slide-menu-dropi.svg" alt=""></span>
									</a>
									<!-- Dropdown level 1 -->
									<div id="dropdown-lvl2" class="panel-collapse collapse show" data-parent="#menu-accordian">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												@foreach($transactionLiveData as $k => $row)
												<li @if($k == 0) class="active" @endif><a href="javascript:;"><span><img src="{{ asset('public/assets/') }}/images/sub-dropdown-icon.svg" alt=""></span> {{ $row->name }}</a></li>
												@endforeach
											</ul>
										</div>
									</div>
								</li>
								@endif

								<!-- Dropdown-->
								@if($transactionMaturedData)
								<li class="panel panel-default" id="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvl1">
										<span><img src="{{ asset('public/assets/') }}/images/matured-icon.svg" alt=""></span> Matured <span class="caret-icon"><img src="{{ asset('public/assets/') }}/images/slide-menu-dropi.svg" alt=""></span>
									</a>
									<!-- Dropdown level 1 -->
									<div id="dropdown-lvl1" class="panel-collapse collapse" data-parent="#menu-accordian">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												@foreach($transactionMaturedData as $k => $row)
												<li @if($k == 0) class="active" @endif><a href="javascript:;"><span><img src="{{ asset('public/assets/') }}/images/sub-dropdown-icon.svg" alt=""></span> {{ $row->name }}</a></li>
												@endforeach
											</ul>
										</div>
									</div>
								</li>
								@endif
							</ul>
						</div><!-- /.navbar-collapse -->
					</nav>
				</div>

				<div class="side-body">
					<div class="transaction-container">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
		
	(function($){
		$(window).on("load",function(){				
			$("#content-1").mCustomScrollbar({
				theme:"minimal",
				scrollInertia: 60,
			});				
		});
	})(jQuery);	
		

	$(document).ready(function() {
		$('.mtb_category_scroller').owlCarousel({
			margin: 10,
			loop: false,
			nav:true,
			navText: ["<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>","<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>"],  
			autoWidth: true,
			items: 4
		});
	});
});
</script>