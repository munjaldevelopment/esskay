@if(trim($insightCatData->description) != "")
<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
		{!! $insightCatData->description !!}
	</ul>
</div>
@endif

@if($insightCatData->id == 1)
	<div class="alert alert-success text-center">Coming Soon</div>
@elseif($insightCatData->id == 2)
	<div class="white-box">
		<div class="operational-highlights-main">
			<div class="operation-highlights-area">
				<div class="operation-highlight-year">
					<div class="ohbh-box-insight-left">
						{{ $insightFirst->operation_row1_year }}
					</div>
					<div class="ohbh-box-insight-right">
						{{ $insightFirst->operation_row2_year }}
					</div>
				</div>
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
			</div>
			

			<div class="operation-highlights-area operation-single-highlighs">
				<div class="operation-highlight-year">
					<div class="ohbh-box-insight-left">&nbsp;</div>
					<div class="ohbh-box-insight-right">
						{{ $insightFirst->operation_row3_year }}
					</div>
				</div>
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
				
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 3)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart1)
				<div id="first_chart"></div>

				{!! $chart1 !!}
			@endif
		</div>
	</div>
	
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Outstanding As on (In Cr.)</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th style="min-width: 140px;" rowspan="2">Geographical <br /> Diversification</th>
								<th style="min-width: 90px;" rowspan="2">DOCP</th>
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
								<td>{{ number_format($row->amount1, 0) }}</td>
								<td>{{ number_format($row->amount_percentage1, 0) }}%</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ number_format($row->amount_percentage2, 0) }}%</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ number_format($row->amount_percentage3, 0) }}%</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ number_format($row->amount_percentage4, 0) }}%</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ number_format($row->amount_percentage5, 0) }}%</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ number_format($row->amount_percentage6, 0) }}%</td>
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ number_format($row->amount_percentage7, 0) }}%</td>
								<td>{{ number_format($row->amount8, 0) }}</td>
								<td>{{ number_format($row->amount_percentage8, 0) }}%</td>
								<td>{{ number_format($row->amount9, 0) }}</td>
								<td>{{ number_format($row->amount_percentage9, 0) }}%</td>
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td>Total</td>
								<td>&nbsp;</td>
								<td>{{ $geographicalConTotalData['amount1'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount2'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount3'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount4'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount5'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount6'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount7'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount8'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount9'] }}</td>
								<td>100%</td>
							</tr>
						</tfoot>
					</table>	
				</div>	
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 4)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart2)
				<div id="second_chart"></div>

				{!! $chart2 !!}
			@endif
		</div>
	</div>
	
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Outstanding As on (In Cr.)</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th style="min-width: 170px;" rowspan="2">Product <br /> Diversification</th>
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
							@foreach($productConData as $row)
							<tr>
								<td>{{ $row->product_diversification }}</td>
								<td>{{ number_format($row->amount1, 0) }}</td>
								<td>{{ number_format($row->amount_percentage1, 0) }}%</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ number_format($row->amount_percentage2, 0) }}%</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ number_format($row->amount_percentage3, 0) }}%</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ number_format($row->amount_percentage4, 0) }}%</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ number_format($row->amount_percentage5, 0) }}%</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ number_format($row->amount_percentage6, 0) }}%</td>
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ number_format($row->amount_percentage7, 0) }}%</td>
								<td>{{ number_format($row->amount8, 0) }}</td>
								<td>{{ number_format($row->amount_percentage8, 0) }}%</td>
								<td>{{ number_format($row->amount9, 0) }}</td>
								<td>{{ number_format($row->amount_percentage9, 0) }}%</td>
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td>Total</td>
								<td>{{ $productConTotalData['amount1'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount2'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount3'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount4'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount5'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount6'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount7'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount8'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount9'] }}</td>
								<td>100%</td>
							</tr>
						</tfoot>
					</table>	
				</div>	
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 5)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart3)
				<div id="third_chart"></div>

				{!! $chart3 !!}
			@endif
		</div>
	</div>
@elseif($insightCatData->id == 6)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart41)
				<div id="fourth1_chart"></div>

				{!! $chart41 !!}
			@endif
		</div>
	</div>

	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart42)
				<div id="fourth2_chart"></div>

				{!! $chart42 !!}
			@endif
		</div>
	</div>
@elseif($insightCatData->id == 8)
	<div class="row">
		<div class="col-sm-6">
			<div class="white-box">
				<div class="pool-dynamic-graph">
					@if($chart51)
						<div id="fifth1_chart"></div>

						{!! $chart51 !!}
					@endif
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="white-box">
				<div class="pool-dynamic-graph">
					@if($chart52)
						<div id="fifth2_chart"></div>

						{!! $chart52 !!}
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Capital Infusion Detail</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Month</th>
								@foreach($netWorthData as $row)
								<th>{{ $row->month }}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Capital Infusion</td>
								@foreach($netWorthData as $row)
								<td>{{ $row->capital_infusion }}</td>
								@endforeach
							</tr>
							<tr>
								<td>Investors</td>
								@foreach($netWorthData as $row)
								<td>{!! $row->investors !!}</td>
								@endforeach
							</tr>
						</tbody>
					</table>	
				</div>	
			</div>
		</div>
	</div>

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Reconciliation of Net worth (In Cr.)</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Particulars</th>
								<th>FY-16</th>
								<th>FY-17</th>
								<th>FY-18</th>
								<th>FY-19</th>
								<th>FY-20</th>
								<th>FY-21</th>
							</tr>
						</thead>
						<tbody>
							@foreach($netWorthData1 as $row)
							<tr>
								<td>{{ $row->particulars}}</td>
								<td>{{ $row->amount1}}</td>
								<td>{{ $row->amount2}}</td>
								<td>{{ $row->amount3}}</td>
								<td>{{ $row->amount4}}</td>
								<td>{{ $row->amount5}}</td>
								<td>{{ $row->amount6}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>	
				</div>	
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 9)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart6)
				<div id="sixth_chart"></div>

				{!! $chart6 !!}
			@endif
		</div>
	</div>

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Quarter on Quarter Liquidity Position (In Cr.)</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th> Quarter on Quarter Liquidity</th>
								<th>Dec-18</th>
								<th>Mar-19</th>
								<th>Jun-19</th>
								<th>Sep-19</th>
								<th>Dec-19</th>
								<th>Mar-20</th>
								<th>Jun-20</th>
								<th>Sep-20</th>
								<th>Dec-20</th>
								<th>Mar-21</th>
							</tr>
						</thead>
						<tbody>
							@foreach($liquidityData as $row)
							<tr>
								<td>{{ $row->quarter}}</td>
								<td>{{ $row->amount1}}</td>
								<td>{{ $row->amount2}}</td>
								<td>{{ $row->amount3}}</td>
								<td>{{ $row->amount4}}</td>
								<td>{{ $row->amount5}}</td>
								<td>{{ $row->amount6}}</td>
								<td>{{ $row->amount7}}</td>
								<td>{{ $row->amount8}}</td>
								<td>{{ $row->amount9}}</td>
								<td>{{ $row->amount10}}</td>
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td>Total</td>
								<td>{{ $liquidityDataTotal[0] }}</td>
								<td>{{ $liquidityDataTotal[1] }}</td>
								<td>{{ $liquidityDataTotal[2] }}</td>
								<td>{{ $liquidityDataTotal[3] }}</td>
								<td>{{ $liquidityDataTotal[4] }}</td>
								<td>{{ $liquidityDataTotal[5] }}</td>
								<td>{{ $liquidityDataTotal[6] }}</td>
								<td>{{ $liquidityDataTotal[7] }}</td>
								<td>{{ $liquidityDataTotal[8] }}</td>
								<td>{{ $liquidityDataTotal[9] }}</td>
							</tr>
						</tfoot>
					</table>	

					<p class="tab-spacing">
						Note: <br />
						1. Our mandate /threshold is to maintain minimum liquidity equivalent to 3 months disbursements (+) repayments (-) collections. <br />
						2. Apart from the above we have undrawn sanctions amounting to Rs. 578 crores from different lenders.
					</p>
				</div>	
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 12) 

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Detail of COVID relief from lenders</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Name of the Bank / Institution</th>
								<th>April EMI</th>
								<th>May EMI</th>
								<th>Total EMI</th>
							</tr>
						</thead>
						<tbody>
							@php
								$count = 1;
							@endphp
							@foreach($covidReliefData as $k => $row)
							<tr>
								<td>{{ $count }}</td>
								<td>{{ $row->bank_name }}</td>
								<td>{{ $row->april_emi }}</td>
								<td>{{ $row->may_emi }}</td>
								<td>{{ $covidReliefDataTotal1[$k] }}</td>
							</tr>
								@php
									$count++;
								@endphp
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td>&nbsp;</td>
								<td>Total</td>
								<td>{{ $covidReliefDataTotal['amount1'] }}</td>
								<td>{{ $covidReliefDataTotal['amount2'] }}</td>
								<td>{{ $covidReliefDataTotal['amount3'] }}</td>
							</tr>
						</tfoot>
					</table>	

					<p class="tab-spacing">
						In reference to the moratorium from lenders Company had requested  moratorium 1 for EMIs  of April and May 2020 as debt servicing for March was already done. However, as on June 30, 2020 we repaid back all the EMI outflows saved pertaining to moratorium 1 phase except for Indusind Bank as they did not allow us to make repayment. Effectively for all practical purpose as we speak we have not availed moratorium from above lenders except Indusind Bank and the repayment schedule is now restated to the Originals levels for the remaining tenure.
					</p>
				</div>	
			</div>
		</div>
	</div>


	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Detail of COVID relief to Borrowers</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Particulars</th>
								<th>Apr-20</th>
								<th>May-20</th>
								<th>Jun-20</th>
								<th>Jul-20</th>
								<th>Aug-20</th>
								<th>Sep-20</th>
							</tr>
						</thead>
						<tbody>
							@foreach($covidRelief1Data as $k => $row)
							<tr>
								<td>{{ $row->particulars }}</td>
								<td>{{ $row->april_20 }}</td>
								<td>{{ $row->may_20 }}</td>
								<td>{{ $row->june_20 }}</td>
								<td>{{ $row->july_20 }}</td>
								<td>{{ $row->august_20 }}</td>
								<td>{{ $row->sept_20 }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>	

					<p class="tab-spacing">
						with respect to the moratorium numbers would also like to highlight that we have also used this opportunity which in the normal course otherwise not available to borrowers wherein we extended moratorium to our overdue borrowers irrespective of the fact that they were paying EMI's in order to ensure that by the time moratorium is over they get rolled back to earlier bucket and start with the clean slate going forward when moratorium period is over.
					</p>
				</div>	
			</div>
		</div>
	</div>
@endif

@if($insightCatData->id == 2)
<script src="{{ asset('public/assets/') }}/js/highcharts.js"></script>
<script src="{{ asset('public/assets/') }}/js/series-label.js"></script>
<script src="{{ asset('public/assets/') }}/js/exporting.js"></script>
<script src="{{ asset('public/assets/') }}/js/export-data.js"></script>
@endif

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
});
</script>