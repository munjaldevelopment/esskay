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
												<li class="transaction-contentainer transaction-content-row{{ $row->id }} @if($k == 0) active @endif"><a class="transaction-content-container{{ $row->id }} transaction-row" data-transaction="{{ $row->id }}" href="javascript:;"><span><img src="{{ asset('public/assets/') }}/images/sub-dropdown-icon.svg" alt=""></span> {{ $row->name }}</a></li>
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
												<li class="transaction-content-row{{ $row->id }} @if($k == 0) active @endif"><a class="transaction-row" data-transaction="{{ $row->id }}" href="javascript:;"><span><img src="{{ asset('public/assets/') }}/images/sub-dropdown-icon.svg" alt=""></span> {{ $row->name }}</a></li>
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
						<div class="alert alert-warning">There are no transaction in this category.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="category_id" id="transaction_category_id" value="{{ $category_id }}">

<div class="preloader_doc" style="display:none">
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
		<g transform="rotate(0 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(30 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(60 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(90 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(120 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(150 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(180 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(210 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(240 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(270 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(300 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(330 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>
		  </rect>
		</g>
		</svg>
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

    (function($){
		$(window).on("load",function(){
			$("#content-1").mCustomScrollbar({
				theme:"minimal",
				scrollInertia: 60,
			});				
		});
	})(jQuery);	

	$('.transaction-row').bind('click', function() {
		var transaction_id = $(this).attr('data-transaction');
		var transaction_category_id = $('#transaction_category_id').val();

		$('.transaction-contentainer').removeClass('active');

		$('.transaction-content-row'+transaction_id).addClass('active');
		
		$.ajax({
			url: base_url+'showTrusteeTransactionInfo',
			type: 'post',
			data: {_token: CSRF_TOKEN, transaction_id: transaction_id, transaction_category_id: transaction_category_id},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.transaction-container').html(content);
			},
			success: function(output) {
				$('.transaction-container').html(output);

				
			}
		});
	});

	@if(isset($transactionLiveData[0]))
	$('.transaction-content-container{{ $transactionLiveData[0]->id }}').trigger('click');
	@endif
});
</script>