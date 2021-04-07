<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
		{!! $cat_name !!}
	</ul>
</div>

@if($subCategory)
<div class="mtb-inner-category">
	<div class="owl-carousel mtb_category_scroller">
		@foreach($subCategory as $id => $subCategoryRow)
		<div class="sub-category-row sub-sub-category{{$subCategoryRow['id']}} item @if($id == 0) active @endif">
			<a href="javascript:;" class="sub-dropdown-box" data-category="{{$subCategoryRow['id']}}">{{ $subCategoryRow['name'] }}</a>
		</div>
		@endforeach
	</div>
</div>
@endif

<div class="sub-doc-container">
	@if($is_timeline)
	<div class="mtd-timeline">
		<ul>
			@php
				$count = 1;
			@endphp
			@foreach($documentDateData as $k => $doc_date)
			<li class="time-container @if($docu_date == $doc_date) active @endif" name="{{ $doc_date }}">
				<a href="javascript:;" class="btn-date" data-date="{{ $doc_date }}">
					{{ $doc_date }}
				</a>
			</li>
				@php
					$count++;
				@endphp
			@endforeach
		</ul>
	</div>
	@endif

	<div class="mtd-timeline-content">
		<div class="border-title">	
			<span>{{ $category_name }}</span>
		</div>

		<div class="mtd-timline-document">
			<div class="row">
				@if($docData)
					@foreach($docData as $id1 => $doc)
					<div class="col-md-6 col-sm-12">
						<div class="mtd-doc-box">	
							<div class="mtdd-doc-img">
								<i class="fa fa-file-{{ $doc['ext'] }}-o" aria-hidden="true"></i>
							</div>
							<div class="mtdd-doc-cont">
								<h4> {{ $doc['document_heading'] }} </h4>	
								<p>{!! date('F d, Y', strtotime($doc['expiry_date'])) !!}</p>													
							</div>
							<div class="download-container{{ $doc['id'] }} mtdd-doc-check">
								@if($doc['doc_download'] > 0)
								<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
								@endif
							</div>
							<div class="mtd-doc-hover">
								<ul>
									<li>
										@if($doc['ext'] == 'pdf')
										<a href="{{ asset('/') }}previewDocTrustee/{{ base64_encode($doc['id']) }}" target="_blank"><i class="fa fa-refresh" aria-hidden="true"></i></a>
										@endif
									</li>

									<li>
										<a href="{{ asset('/') }}downloadDocTrustee/{{ base64_encode($doc['id']) }}" onclick="showDownloadIcon('{{ $doc['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>

						@if(($id1 % 2) == 1)
							</div>
							<div class="row">
						@endif
					@endforeach
				@endif
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
function showDownloadIcon(doc_id)
{
	$('.download-container'+doc_id).html('<p class="right-arrow"><i class="fa fa-check"></i></p>');
}

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.sub-dropdown-box').bind('click', function() {
		var category = $(this).attr('data-category');
		
		//alert(category);
		var document_date = $('.assign_date').val();
		
		$.ajax({
			url: base_url+'showChildDocTrustee',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: category, document_date: document_date},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.sub-doc-container').html(content);
			},
			success: function(output) {
				$('.sub-doc-container').html(output);

				$('.assign_date').val('{{ $current_year }}');

				$('.sub-category-row').removeClass('active');

				$('.sub-sub-category'+category).addClass('active');
			}
		});
		
		//$('ul.category-listing li').removeClass('active');
				
		//$('ul.category-listing li a[data-category="'+category+'"]').parent('li').addClass("active");
	});
	
	$('.doc-download').bind('click', function() {
		var document = $(this).attr('data-document');
		var category = $(this).attr('data-category');
		var sub_category_id = $(this).attr('data-sub-category');
		
		//alert(document);
		
		$.ajax({
			url: base_url+'downloadDocTrustee',
			type: 'post',
			data: {_token: CSRF_TOKEN, document_id: document},
			beforeSend: function() {
			},
			success: function(output) {
				swal({
					title: "Success",
					text: "File has been downloaded",
					icon: "success",
					button: "Continue",
				});
				
				$.ajax({
					url: base_url+'showDoc',
					type: 'post',
					data: {_token: CSRF_TOKEN, category_id: category},
					beforeSend: function() {
					},
					success: function(output) {
						$('.doc-container').html(output);
					}
				});
			}
		});
	});

	$('.btn-date').bind('click', function() {
		var date1 = $(this).attr('data-date');		
		
		//alert(date1);
		$('.assign_date').val(date1);
		
		$('.time-container').removeClass('active');
				
		$('li[name="'+date1+'"]').addClass("active");
		
		$('.category-listing li.active .sub-dropdown-box').trigger('click');
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
		  })
		})	
		
});
</script>