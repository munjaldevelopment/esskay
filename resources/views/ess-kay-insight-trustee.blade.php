<div class="main-tab-details">
	<!-- Tab panes -->
	<div class="tab-content">
		 <div class="mtd-inner-box">
			<div class="mtd-inner">
				@if($parentCategoryData)
				<div class="side-body side-body-content side-body-full">
					<div class="mtb-inner-category">
						<div class="owl-carousel mtb_category_scroller">
							@php
								$count = 1;
							@endphp
							@foreach($parentCategoryData as $cat_id => $name)
							<div class="insight-category item @if($count == 1) active @endif">
								<a class="insight-category-list insight-category-cat{{ $cat_id }}" data-insight="{{ $cat_id }}" href="javascript:;">{{ $name }}</a>
							</div>
								@php
									$count++;
								@endphp
							@endforeach
						</div>
					</div>
				</div>
				@endif

				<div class="side-body side-body-content side-body-full">
					<div class="insight-container">
						<div class="alert alert-warning">
							Please click on top section to get data
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
	
	$('.mtb_category_scroller').owlCarousel({
		margin: 10,
		loop: false,
		nav:true,
		navText: ["<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>","<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>"],  
		autoWidth: true,
		items: 4
	});

	$('.insight-category-list').bind('click', function() {
		var insight_category = $(this).attr('data-insight');
		
		$.ajax({
			url: base_url+'showInsightTrustee',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: insight_category},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.insight-container').html(content);
			},
			success: function(output) {
				$('.insight-container').html(output);
			}
		});
		
		$('.mtb_category_scroller .item').removeClass('active');
				
		$(this).parent('.item').addClass("active");
	});

	$('.insight-category-cat2').trigger('click');
});
</script>
