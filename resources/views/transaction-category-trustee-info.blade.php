<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
	  <li><a href="javascript:;">{{ $categoryData->category_name }}</a></li>
	  <li>{{ $transactionData->name }}</li>
	</ul>
</div>

<div class="mtb-inner-category">
	<div class="owl-carousel mtb_category_scroller">
		<div class="item report-type-container report-type-container1 active">
			<a class="btn-report-type" data-val="1" href="javascript:;">Executed Documents</a>
		</div>
		<div class="item report-type-container report-type-container2">
			<a class="btn-report-type" data-val="2" href="javascript:;">Monthly Payout Report</a>
		</div>
		<div class="item report-type-container report-type-container3">
			<a class="btn-report-type" data-val="3" href="javascript:;">Collection efficiency</a>
		</div>
		<div class="item report-type-container report-type-container4">
			<a class="btn-report-type" data-val="4" href="javascript:;">Pool Dynamics</a>
		</div>

		@if($transaction_category_id == 3 || $transaction_category_id == 4 || $transaction_category_id == 5 || $transaction_category_id == 6)
		<div class="item report-type-container report-type-container5">
			<a class="btn-report-type" data-val="5" href="javascript:;">Charge Creation / Modification</a>
		</div>
		<div class="item report-type-container report-type-container6">
			<a class="btn-report-type" data-val="6" href="javascript:;">Satisfaction of Charge</a>
		</div>
		@elseif($transaction_category_id == 7 || $transaction_category_id == 8 || $transaction_category_id == 9)
		<div class="item report-type-container report-type-container7">
			<a class="btn-report-type" data-val="7" href="javascript:;">Charge Creation / Modification</a>
		</div>
		<div class="item report-type-container report-type-container6">
			<a class="btn-report-type" data-val="6" href="javascript:;">Satisfaction of Charge</a>
		</div>
		@endif
	  </div>
</div>

<input type="hidden" id="transaction_id" name="transaction_id" value="{{ $transaction_id }}" />

<div class="mtd-timline-document">
	<div class="row">
		@if($relevantPartyInvestorData)
		<div class="col-md-4 col-sm-12">
			<div class="mtd-container-box">
				<div class="mtdd-doc-cont">
					<h4>Investor </h4>
					<div>
						@foreach($relevantPartyInvestorData as $row)
						<p>EssKay1</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($relevantPartyTrusteeData)
		<div class="col-md-4 col-sm-12">
			<div class="mtd-container-box">
				<div class="mtdd-doc-cont">
					<h4>Trustee </h4>
					<div>
						@foreach($relevantPartyTrusteeData as $row)
						<p>EssKay1</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($relevantPartyLegalData)
		<div class="col-md-4 col-sm-12">
			<div class="mtd-container-box">
				<div class="mtdd-doc-cont">
					<h4>Legal </h4>
					<div>
						@foreach($relevantPartyLegalData as $row)
						<p>EssKay1</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($relevantPartyArrangerData)
		<div class="col-md-4 col-sm-12">
			<div class="mtd-container-box">
				<div class="mtdd-doc-cont">
					<h4>Arranger </h4>
					<div>
						@foreach($relevantPartyArrangerData as $row)
						<p>EssKay1</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($relevantPartyRatingData)
		<div class="col-md-4 col-sm-12">
			<div class="mtd-container-box">
				<div class="mtdd-doc-cont">
					<h4>Rating </h4>
					<div>
						@foreach($relevantPartyRatingData as $row)
						<p>EssKay1</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>

<div class="mtd-timeline-content trustee-transaction-document-container">
	
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

	$('.btn-report-type').bind('click', function() {
		var report_type = $(this).attr('data-val');
		var transaction_id = $('#transaction_id').val();
		
		$.ajax({
			url: base_url+'showTrusteeTransactionDocumentInfo',
			type: 'post',
			data: {_token: CSRF_TOKEN, transaction_id: transaction_id, report_type: report_type},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.trustee-transaction-document-container').html(content);
			},
			success: function(output) {
				$('.report-type-container').removeClass('active');
				
				$('.report-type-container'+report_type).addClass('active');
				$('.trustee-transaction-document-container').html(output);
			}
		});
	});

	$('.btn-report-type[data-val="1"]').trigger('click');
});	

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

</script>