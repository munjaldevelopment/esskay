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
						<div class="ohbh-box-left">{{ $insightRow->operation_row1_value }}</div>
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">{{ $insightRow->operation_row1_income }}</div>
									<div class="ohbh-mid-result">{{ $insightRow->operation_row1_income_percentage }}%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">{{ $insightRow->operation_row2_value }} </div>
					</div>
					@endforeach
				</div>
				<div class="operation-highlight-year">
					{{ $insightFirst->operation_row1_year }}
				</div>
			</div>
			

			<div class="operation-highlights-area operation-single-highlighs">
				<div class="operation-highlight-cont">
					@foreach($insightData as $insightRow)
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">{{ $insightRow->operation_row2_income }}</div>
									<div class="ohbh-mid-result">{{ $insightRow->operation_row2_income_percentage }}%</div>
								</div>
							</div>
						</div>
						<div class="ohbh-box-right">{{ $insightRow->operation_row3_value }} </div>
					</div>
					@endforeach
				</div>
				<div class="operation-highlight-year">
					{{ $insightFirst->operation_row2_year }}
				</div>
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 3)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			<img src="images/graph-img.png" alt="">
		</div>
	</div>
	
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Outstanding As on</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th rowspan="2">Geographical <br /> Diversification</th>
								<th rowspan="2">DOCP</th>
								<th colspan="2" class="border-bottom">Mar-16</th>
								<th colspan="2" class="border-bottom">Mar-17</th>
								<th colspan="2" class="border-bottom">Mar-18</th>
								<th colspan="2" class="border-bottom">Mar-19</th>
								<th colspan="2" class="border-bottom">Mar-20</th>
								<th colspan="2" class="border-bottom">Sep-20</th>
								<th colspan="2" class="border-bottom">Mar-21</th>
								<th colspan="2" class="border-bottom">Mar-22</th>
								<th colspan="2" class="border-bottom">Mar-23</th>
							</tr>
							<tr>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
							</tr>
						</thead>
						<tbody>
							@foreach($geographicalConData as $row)
							<tr>
								<td>{{ $row->geographical_diversification }}</td>
								<td>{{ $row->docp }}</td>
								<td>{{ $row->amount1 }}</td>
								<td>{{ $row->amount_percentage1 }}%</td>
								<td>{{ $row->amount2 }}</td>
								<td>{{ $row->amount_percentage2 }}%</td>
								<td>{{ $row->amount3 }}</td>
								<td>{{ $row->amount_percentage3 }}%</td>
								<td>{{ $row->amount4 }}</td>
								<td>{{ $row->amount_percentage4 }}%</td>
								<td>{{ $row->amount5 }}</td>
								<td>{{ $row->amount_percentage5 }}%</td>
								<td>{{ $row->amount6 }}</td>
								<td>{{ $row->amount_percentage6 }}%</td>
								<td>{{ $row->amount7 }}</td>
								<td>{{ $row->amount_percentage7 }}%</td>
								<td>{{ $row->amount8 }}</td>
								<td>{{ $row->amount_percentage8 }}%</td>
								<td>{{ $row->amount9 }}</td>
								<td>{{ $row->amount_percentage9 }}%</td>
							</tr>
							@endforeach
						</tbody>
					</table>	
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