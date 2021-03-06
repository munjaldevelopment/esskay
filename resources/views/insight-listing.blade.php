<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
		{!! $insightCatData->description !!}
	</ul>
</div>

@if($insightCatData->id == 1)
	<div class="alert alert-success text-center">Coming Soon</div>
@elseif($insightCatData->id == 2)
	<div class="white-box">
		<div class="operational-highlights-main">
			<div class="operation-highlights-area">
				<div class="operation-highlight-cont">
					@foreach($insightData as $insightRow)
					<div class="ohb-highlights-box">
						<div class="ohbh-box-left">381</div>
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">{{ $insightRow->operation_row1_income }}</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">582 </div>
					</div>
					@endforeach
				</div>
				<div class="operation-highlight-year">
					2019
				</div>
			</div>

			<div class="operation-highlights-area operation-single-highlighs">
				<div class="operation-highlight-cont">
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">Total<br>Income</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">582 </div>
					</div>
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">Branches</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">325</div>
					</div>
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">Profit After <br>tax</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">79</div>
					</div>
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">Annual Disbursement</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">2194 </div>
					</div>
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">AUM</div>
									<div class="ohbh-mid-result">52.75%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">2986</div>
					</div>
				</div>
				<div class="operation-highlight-year">
					2020
				</div>
			</div>
		</div>
	</div>
@endif
<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
});
</script>