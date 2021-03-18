<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
	  <li><a href="#">{{ $categoryData->category_name }}</a></li>
	  <li>{{ $transactionData->name }}</li>
	</ul>
</div>

<div class="mtb-inner-category">
	<div class="owl-carousel mtb_category_scroller">
		<div class="item report-type-container active">
		  <a class="btn-report-type" data-val="1" href="javascript:;">Executed Report</a>
		</div>
		<div class="item report-type-container">
		  <a class="btn-report-type" data-val="2" href="javascript:;">Monthly Payout Report</a>
		</div>
		<div class="item report-type-container">
		  <a class="btn-report-type" data-val="3" href="javascript:;">Collection efficiency</a>
		</div>
		<div class="item report-type-container">
		  <a class="btn-report-type" data-val="4" href="javascript:;">Pool Dynamics</a>
		</div>
	  </div>
</div>

<input type="hidden" id="transaction_id" name="transaction_id" value="{{ $transaction_id }}" />

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

				$(this).parent().find('.report-type-container').addClass('active');
				$('.trustee-transaction-document-container').html(output);
			}
		});
	});
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