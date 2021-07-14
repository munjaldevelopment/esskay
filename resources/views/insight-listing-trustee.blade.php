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
		<div class="pull-right text-right">
			<span class="operational-amount">Amount (In Cr.) </span>
			<div class="mtdd-operation-img">
				<a target="_blank" href="downloadOperationHighlight"><i class="fa fa-2x fa-file-excel-o"></i></a>
			</div>
		</div>

		<div class="clearfix"></div>
		
		<div class="operational-highlights-main">
			<div class="operation-highlights-area">
				<div class="operation-highlight-year">
					<div class="ohbh-box-insight-right">
						{{ $insightFirst->operation_row1_year }}
					</div>
				</div>
				<div class="operation-highlight-cont operation-highlight-cont-first">
					@foreach($insightData as $insightRow)
					<div class="ohb-highlights-box">
						<div class="ohbh-box-right">{{ $insightRow->operation_row1_value }}</div>
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-heading">{{ $insightRow->operation_row1_income }}</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>

			<div class="operation-highlights-area operation-single-highlighs-middle">
				<div class="operation-highlight-year">
					<div class="ohbh-box-insight-right">
						{{ $insightFirst->operation_row2_year }}
					</div>
				</div>
				<div class="operation-highlight-cont">
					@foreach($insightData as $insightRow)
					<div class="ohb-highlights-box">
						<div class="ohbh-box-mid">
							<div class="ohbhb-mid-cont">
								<div class="ohbhb-mid-cont-text">
									<div class="ohbh-mid-result">
									{{ $insightRow->operation_row1_income_percentage }}%

									@if($insightRow->operation_row1_value < $insightRow->operation_row2_value)
										<i class="color-green fa fa-arrow-up"></i> 
									@elseif($insightRow->operation_row1_value > $insightRow->operation_row2_value)
										<i class="color-red fa fa-arrow-down"></i>
									@endif
									</div>
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
									<div class="ohbh-mid-result">
									{{ $insightRow->operation_row2_income_percentage }}%
									@if($insightRow->operation_row3_value > $insightRow->operation_row2_value)
										<i class="color-green fa fa-arrow-up"></i> 
									@elseif($insightRow->operation_row3_value < $insightRow->operation_row2_value)
										<i class="color-red fa fa-arrow-down"></i>
									@endif
									</div>
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
								<th class="text-justify" style="min-width: 140px;" rowspan="2">Geographical <br /> Diversification</th>
								<th style="min-width: 90px;" rowspan="2">DOCP</th>
								<!--<th colspan="2" class="border-bottom">Mar-22</th>-->
								<th colspan="2" class="border-bottom">Mar-21</th>
								<th colspan="2" class="border-bottom">Sep-20</th>
								<th colspan="2" class="border-bottom">Mar-20</th>
								<th colspan="2" class="border-bottom">Mar-19</th>
								<th colspan="2" class="border-bottom">Mar-18</th>
								<th colspan="2" class="border-bottom">Mar-17</th>
								<th colspan="2" class="border-bottom">Mar-16</th>
								<!--<th colspan="2" class="border-bottom">Mar-23</th>-->
							</tr>
							<tr>
								<th>Amount</th>
								<th>%</th>
								<th>Amount</th>
								<th>%</th>
								<!--<th>Amount</th>
								<th>%</th>-->
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
								<!--<th>Amount</th>
								<th>%</th>-->
							</tr>
						</thead>
						<tbody>
							@foreach($geographicalConData as $row)
							<tr>
								<td class="text-justify">{{ $row->geographical_diversification }}</td>
								<td>{{ $row->docp }}</td>
								<!--<td>{{ number_format($row->amount8, 0) }}</td>
								<td>{{ number_format($row->amount_percentage8, 0) }}%</td>-->
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ number_format($row->amount_percentage7, 0) }}%</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ number_format($row->amount_percentage6, 0) }}%</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ number_format($row->amount_percentage5, 0) }}%</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ number_format($row->amount_percentage4, 0) }}%</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ number_format($row->amount_percentage3, 0) }}%</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ number_format($row->amount_percentage2, 0) }}%</td>
								<td>{{ number_format($row->amount1, 0) }}</td>
								<td>{{ number_format($row->amount_percentage1, 0) }}%</td>
								<!--<td>{{ number_format($row->amount9, 0) }}</td>
								<td>{{ number_format($row->amount_percentage9, 0) }}%</td>-->
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td class="text-justify">Total</td>
								<td>&nbsp;</td>
								<!--<td>{{ $geographicalConTotalData['amount8'] }}</td>
								<td>100%</td>-->
								<td>{{ $geographicalConTotalData['amount7'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount6'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount5'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount4'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount3'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount2'] }}</td>
								<td>100%</td>
								<td>{{ $geographicalConTotalData['amount1'] }}</td>
								<td>100%</td>
								<!--<td>{{ $geographicalConTotalData['amount9'] }}</td>
								<td>100%</td>-->
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
								<th class="text-justify" style="min-width: 170px;" rowspan="2">Product <br /> Diversification</th>
								<!--<th colspan="2" class="border-bottom">Mar-22</th>-->
								<th colspan="2" class="border-bottom">Mar-21</th>
								<th colspan="2" class="border-bottom">Sep-20</th>
								<th colspan="2" class="border-bottom">Mar-20</th>
								<th colspan="2" class="border-bottom">Mar-19</th>
								<th colspan="2" class="border-bottom">Mar-18</th>
								<th colspan="2" class="border-bottom">Mar-17</th>
								<th colspan="2" class="border-bottom">Mar-16</th>
								<!--<th colspan="2" class="border-bottom">Mar-23</th>-->
							</tr>
							<tr>
								<th>Amount</th>
								<th>%</th>
								<!--<th>Amount</th>
								<th>%</th>-->
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
								<!--<th>Amount</th>
								<th>%</th>-->
							</tr>
						</thead>
						<tbody>
							@foreach($productConData as $row)
							<tr>
								<td class="text-justify">{{ $row->product_diversification }}</td>
								<!--<td>{{ number_format($row->amount8, 0) }}</td>
								<td>{{ number_format($row->amount_percentage8, 0) }}%</td>-->
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ number_format($row->amount_percentage7, 0) }}%</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ number_format($row->amount_percentage6, 0) }}%</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ number_format($row->amount_percentage5, 0) }}%</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ number_format($row->amount_percentage4, 0) }}%</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ number_format($row->amount_percentage3, 0) }}%</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ number_format($row->amount_percentage2, 0) }}%</td>
								<td>{{ number_format($row->amount1, 0) }}</td>
								<td>{{ number_format($row->amount_percentage1, 0) }}%</td>
								<!--<td>{{ number_format($row->amount9, 0) }}</td>
								<td>{{ number_format($row->amount_percentage9, 0) }}%</td>-->
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td class="text-justify">Total</td>
								<!--<td>{{ $productConTotalData['amount8'] }}</td>
								<td>100%</td>-->
								<td>{{ $productConTotalData['amount7'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount6'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount5'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount4'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount3'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount2'] }}</td>
								<td>100%</td>
								<td>{{ $productConTotalData['amount1'] }}</td>
								<td>100%</td>
								<!--<td>{{ $productConTotalData['amount9'] }}</td>
								<td>100%</td>-->
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

	<div class="row">
		<div class="col-sm-6">
			@if($chart31)
				<div id="third1_chart"></div>

				{!! $chart31 !!}
			@endif
		</div>

		<div class="col-sm-6">
			@if($chart32)
				<div id="third2_chart"></div>

				{!! $chart32 !!}
			@endif
		</div>
	</div>
@elseif($insightCatData->id == 6)
	<div class="white-box d-none hide">
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
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Capital Infusion Detail</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-justify" style="min-width: 200px;">Month</th>
								@foreach($netWorthData as $row)
								<th>{{ $row->month }}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-justify" style="min-width: 200px;">Capital Infusion (In Cr.)</td>
								@foreach($netWorthData as $row)
								<td>{{ $row->capital_infusion }}</td>
								@endforeach
							</tr>
							<tr>
								<td class="text-justify">Investors</td>
								@foreach($netWorthData as $row)
								<td>
									<div class="pull-left text-justify unlisted-bullet">
										{!! $row->investors !!}
									</div>
								</td>
								@endforeach
							</tr>
						</tbody>
					</table>	
				</div>	
			</div>
		</div>
	</div>

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
			<h3>Reconciliation of Net worth (In Cr.)</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-justify">Particulars</th>
								<th>FY-21</th>
								<th>FY-20</th>
								<th>FY-19</th>
								<th>FY-18</th>
								<th>FY-17</th>
								<th>FY-16</th>
							</tr>
						</thead>
						<tbody>
							@foreach($netWorthData1 as $row)
							<tr>
								<td style="width:340px;" class="text-justify">{{ $row->particulars}}</td>
								<td>{{ round($row->amount6, 0) }}</td>
								<td>{{ round($row->amount5, 0) }}</td>
								<td>{{ round($row->amount4, 0) }}</td>
								<td>{{ round($row->amount3, 0) }}</td>
								<td>{{ round($row->amount2, 0) }}</td>
								<td>{{ round($row->amount1, 0) }}</td>
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
								<th class="text-justify"> Quarter on Quarter Liquidity</th>
								<th>Mar-21</th>
								<th>Dec-20</th>
								<th>Sep-20</th>
								<th>Jun-20</th>
								<th>Mar-20</th>
								<th>Dec-19</th>
								<th>Sep-19</th>
								<th>Jun-19</th>
								<th>Mar-19</th>
								<th>Dec-18</th>
							</tr>
						</thead>
						<tbody>
							@foreach($liquidityData as $row)
							<tr>
								<td class="text-justify">{{ $row->quarter}}</td>
								<td>{{ number_format($row->amount10, 0) }}</td>
								<td>{{ number_format($row->amount9, 0) }}</td>
								<td>{{ number_format($row->amount8, 0) }}</td>
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ number_format($row->amount1, 0) }}</td>
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td class="text-justify">Total</td>
								<td>{{ number_format($liquidityDataTotal[9], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[8], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[7], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[6], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[5], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[4], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[3], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[2], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[1], 0) }}</td>
								<td>{{ number_format($liquidityDataTotal[0], 0) }}</td>
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
@elseif($insightCatData->id == 10)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart7)
				<div id="seventh_chart"></div>

				{!! $chart7 !!}
			@endif
		</div>
	</div>

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Top 5 Lenders</h3>
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
							@foreach($topFiveLenders as $k => $row)
							<td class="">{{ $row->name }}</td>
							@endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>

	<div class="white-box-slider page-inner-tab">
		<div class="mtd-timeline">
			<ul>
				@foreach($liabilityCategories as $k => $row)
				<li class="slider-tab slider-tab-content{{ $k}} @if($k == 0) active @endif"><a onclick="showCategorySlider({{ $k }});" href="javascript:;">{{ $row->name }}</a></li>
				@endforeach
			</ul>
		</div>	
	</div>

	<div class="white-box-slider bank-slider-area">
		@foreach($liabilityCategories as $k => $row)
			<div class="owl-carousel slider_bank_conatiner @if($k > 0) d-none @endif slider_bank_scroll{{ $k }}">
				@if(isset($liabilityCategoriesSlider[$row->id]))
					@foreach($liabilityCategoriesSlider[$row->id] as $rowSlider)
					<div class="item">
					    <div class="bank-slide-img">
							<img src="{{ asset('public/') }}/{{ $rowSlider->image }}" alt="">  
						</div>
					</div>
					@endforeach
				@endif
			</div>
		@endforeach
	</div>

	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-justify" rowspan="2">Lender</th>
								<th colspan="2">Mar-21</th>
								<th colspan="2">Sep-20</th>
								<th colspan="2">Mar-20</th>
								<th colspan="2">Mar-19</th>
								<th colspan="2">Mar-18</th>
								<th colspan="2">Mar-17</th>
								<th colspan="2">Mar-16</th>
							</tr>

							<tr>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
								<th>Amount <br />(In Cr.)</th>
								<th>No. of <br />Lenders</th>
							</tr>
						</thead>
						<tbody>
							@foreach($liabilityProfileTableData as $row)
							<tr>
								<td class="text-justify">{{ $row->lender}}</td>
								<td>{{ number_format($row->amount7, 0) }}</td>
								<td>{{ $row->amount7_lender}}</td>
								<td>{{ number_format($row->amount6, 0) }}</td>
								<td>{{ $row->amount6_lender}}</td>
								<td>{{ number_format($row->amount5, 0) }}</td>
								<td>{{ $row->amount5_lender}}</td>
								<td>{{ number_format($row->amount4, 0) }}</td>
								<td>{{ $row->amount4_lender}}</td>
								<td>{{ number_format($row->amount3, 0) }}</td>
								<td>{{ $row->amount3_lender}}</td>
								<td>{{ number_format($row->amount2, 0) }}</td>
								<td>{{ $row->amount2_lender}}</td>
								<td>{{ number_format($row->amount1, 0) }}</td>
								<td>{{ $row->amount1_lender}}</td>
							</tr>
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<td class="text-justify">Total</td>
								<td>{{ $liabilityProfileDataTotal[12] }}</td>
								<td>{{ $liabilityProfileDataTotal[13] }}</td>
								<td>{{ $liabilityProfileDataTotal[10] }}</td>
								<td>{{ $liabilityProfileDataTotal[11] }}</td>
								<td>{{ $liabilityProfileDataTotal[8] }}</td>
								<td>{{ $liabilityProfileDataTotal[9] }}</td>
								<td>{{ $liabilityProfileDataTotal[6] }}</td>
								<td>{{ $liabilityProfileDataTotal[7] }}</td>
								<td>{{ $liabilityProfileDataTotal[4] }}</td>
								<td>{{ $liabilityProfileDataTotal[5] }}</td>
								<td>{{ $liabilityProfileDataTotal[2] }}</td>
								<td>{{ $liabilityProfileDataTotal[3] }}</td>
								<td>{{ $liabilityProfileDataTotal[0] }}</td>
								<td>{{ $liabilityProfileDataTotal[1] }}</td>
							</tr>
						</tfoot>
					</table>
				</div>	
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 11)
	<div class="white-box d-none hide">
		<div class="pool-dynamic-graph">
			@if($chart8)
				<div id="eighth_chart"></div>

				{!! $chart8 !!}
			@endif
		</div>
	</div>

	<div class="white-box outstanding-box d-none hide">
		<div class="outstanding-table">
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th rowspan="2">Particulars</th>
								<th colspan="3">As per IGAAP</th>
								<th colspan="4">As per IND AS</th>
							</tr>

							<tr>
								<th>FY 21</th>
								<th>H1FY 21</th>
								<th>FY 20</th>
								<th>FY 19</th>
								<th>FY 18</th>
								<th>FY 17</th>
								<th>FY 16</th>
							</tr>
						</thead>
						<tbody>
							@foreach($liabilityProfileTable11Data as $k => $row)
							<tr>
								<td class="text-left">{{ $row->particulars}}</td>
								<td>{{ $row->amount7}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount6}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount5}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount4}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount3}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount2}}@if($k != 1)% @endif</td>
								<td>{{ $row->amount1}}@if($k != 1)% @endif</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>

	<div class="white-box">
		<div class="pool-dynamic-graph">
			<div class="row">
				<div class="col-sm-6">
					@if($chart511)
						<div id="fifth51_chart"></div>

						{!! $chart511 !!}
					@endif
				</div>

				<div class="col-sm-6">
					<h2 style="color:#333333; font-size: 18px; font-family: 'Lucida Grande', 'Lucida Sans Unicode'; margin-top: 15px;" class="text-center text-bold">Resulting in Ratings Upgrade</h2>
					<br /><img src="{{ asset('/').ALMPROFILE_IMAGE }}" />
				</div>
			</div>
		</div>
	</div>

	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart10)
				<div id="tenth_chart"></div>

				{!! $chart10 !!}
			@endif
		</div>
	</div>

	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart512)
				<div id="fifth52_chart"></div>

				{!! $chart512 !!}
			@endif
		</div>
	</div>

	

@elseif($insightCatData->id == 12)
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Detail of COVID relief from lenders (In Nos)</h3>
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
								<th>Sep-20</th>
								<th>Aug-20</th>
								<th>Jul-20</th>
								<th>Jun-20</th>
								<th>May-20</th>
								<th>Apr-20</th>
							</tr>
						</thead>
						<tbody>
							@foreach($covidRelief1Data as $k => $row)
							<tr>
								<td>{{ $row->particulars }}</td>
								<td>{{ $row->sept_20 }}</td>
								<td>{{ $row->august_20 }}</td>
								<td>{{ $row->july_20 }}</td>
								<td>{{ $row->june_20 }}</td>
								<td>{{ $row->may_20 }}</td>
								<td>{{ $row->april_20 }}</td>
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
@elseif($insightCatData->id == 13)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			@if($chart9)
				<div id="ninth_chart"></div>

				{!! $chart9 !!}
			@endif
		</div>
	</div>
@elseif($insightCatData->id == 14)
	<div class="white-box d-none">
		<div class="pool-dynamic-graph">
			<div class="row">
				<div class="col-sm-12">
					<h2>Map</h2>
					<div id="map"></div>

					
				</div>
			</div>
		</div>
	</div>

	<div class="white-box">
		<div class="pool-dynamic-graph">
			<div class="row">
				<div class="col-sm-12">
					<table id="trustee-table" class="display dt-responsive nowrap" style="width:100%">
						<thead>
							<tr>
								<th>Branch Name</th>
								<th>Branch Type</th>
								<th>Location Hub</th>
								<th>District</th>
								<th>State</th>
								<th>Branch Address</th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th>District</th>
								<th>State</th>
								<th></th>
							</tr>
						</tfoot>

						<tbody>
							@foreach($insightLocationData as $row)
							<tr>
								<td>{{ $row->branch_name }}</td>
								<td>{{ $row->branch_type }}</td>
								<td>{{ $row->location_hub }}</td>
								<td>{{ $row->district_name }}</td>
								<td>{{ $row->state_name }}</td>
								<td>{{ $row->branch_address }}</td>
							</tr>
							@endforeach
						</tbody>

						<!---->
					</table>
				</div>
			</div>
		</div>
	</div>
@elseif($insightCatData->id == 15)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			<div id="operational_chart"></div>
		</div>
	</div>
@elseif($insightCatData->id == 16)
	<div class="white-box">
		<div class="pool-dynamic-graph">
			<div id="hierarchy_chart"></div>
		</div>
	</div>
@endif


@if($insightCatData->id == 14)
<style type="text/css">
	#map {
		height: 600px;
	}

	.truncate {
	  max-width:50px;
	  white-space: nowrap;
	  overflow: hidden;
	  text-overflow: ellipsis;
	}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		// Setup - add a text input to each footer cell
	    // DataTable
	    var table = $('#trustee-table').DataTable({
	    	scrollY:        "300px",
        	scrollX:        true,
        	scrollCollapse: true,
        	//fixedColumns: true,
        	initComplete: function () {
	            // Apply the search
	            this.api().columns().every( function (key) {
	            	var column = this;
	                if(key == 3 || key == 4)	                    
					{
						var select = $('<select class="form-control"><option value=""></option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
		                        var val = $.fn.dataTable.util.escapeRegex(
		                            $(this).val()
		                        );
		 
		                        column
		                            .search( val ? '^'+val+'$' : '', true, false )
		                            .draw();
		                });

					
		                column.data().unique().sort().each( function ( d, j ) {
		                    select.append( '<option value="'+d+'">'+d+'</option>' )
		                } );
		            }
	            });
	        }
	    });
	});
</script>
@elseif($insightCatData->id == 15)
<style type="text/css">
	#operational_chart {
	  height: 450px;
	  /*border: 2px dashed #aaa;
	  border-radius: 5px;*/
	  overflow: auto;
	  text-align: center;
	}

	.orgchart {
	  background: #fff; 
	}
	.orgchart td.left, .orgchart td.right, .orgchart td.top {
	  border-color: #aaa;
	}
	.orgchart td>.down {
	  background-color: #aaa;
	}
	.orgchart .top-level .title {
	  background-color: #01a3ae;
	}
	.orgchart .middle-level .title {
	  background-color: #612622;
	}
	.orgchart .middle-level .content {
	  border-color: #612622;
	}
	.orgchart .middle-level1 .title {
	  background-color: #403152;
	}
	.orgchart .middle-level1 .content {
	  border-color: #403152;
	}

	.orgchart .product-dept .title {
	  background-color: #009933;
	}
	.orgchart .product-dept .content {
	  border-color: #009933;
	}
	.orgchart .rd-dept .title {
	  background-color: #993366;
	}
	.orgchart .rd-dept .content {
	  border-color: #993366;
	}
	.orgchart .pipeline1 .title {
	  background-color: #996633;
	}
	.orgchart .pipeline1 .content {
	  border-color: #996633;
	}
	.orgchart .frontend1 .title {
	  background-color: #cc0066;
	}
	.orgchart .frontend1 .content {
	  border-color: #cc0066;
	}
</style>
<script type="text/javascript">
	'use strict';

	(function($){
		$(function() {
			var datascource = 
			@foreach($organisationStructureData as $row)
			{
				'name': '{!! $row['structure_name'] !!}',
				'title': '',
				'className': 'top-level',
				'children': [
					@foreach($row['child'] as $k => $row1)
					{
						'name': '{!! $row1['structure_name'] !!}', 'title': '', 'className': '@if($k == 0) middle-level @else middle-level1 @endif',
					  	'children': [
					  		@foreach($row1['child'] as $k => $row2)
						    {
						    	'name': '{!! $row2['structure_name'] !!}', 'title': '', 'className': 'product-dept',
						      	'children': [
						      		@foreach($row2['child'] as $k => $row3)
							        {
							        	'name': '{!! $row3['structure_name'] !!}', 'title': '', 'className': 'pipeline1',
							        	'children': [
								      		@foreach($row3['child'] as $k => $row4)
									        {
									        	'name': '{{ $row4['structure_name'] }}', 'title': '', 'className': 'pipeline1'
									        },
									        @endforeach
								      	]
							        },
							        @endforeach
						      	]
						    },
						    @endforeach
					  	]
					},
					@endforeach
				]
			};
			@endforeach

			var oc = $('#operational_chart').orgchart({
				'data' : datascource
			});
		});
	})(jQuery);
</script>
@elseif($insightCatData->id == 16)
<style type="text/css">
	#hierarchy_chart {
	  height: 480px;
	  /*border: 2px dashed #aaa;
	  border-radius: 5px;*/
	  overflow: auto;
	  text-align: center;
	}

	.orgchart {
	  background: #fff; 
	}
	.orgchart td.left, .orgchart td.right, .orgchart td.top {
	  border-color: #aaa;
	}
	.orgchart td>.down {
	  background-color: #aaa;
	}
	.orgchart .middle-level .title {
	  background-color: #006699;
	}
	.orgchart .middle-level .content {
	  border-color: #006699;
	}
	.orgchart .product-dept .title {
	  background-color: #009933;
	}
	.orgchart .product-dept .content {
	  border-color: #009933;
	}
	.orgchart .rd-dept .title {
	  background-color: #993366;
	}
	.orgchart .rd-dept .content {
	  border-color: #993366;
	}
	.orgchart .pipeline1 .title {
	  background-color: #996633;
	}
	.orgchart .pipeline1 .content {
	  border-color: #996633;
	}
	.orgchart .frontend1 .title {
	  background-color: #cc0066;
	}
	.orgchart .frontend1 .content {
	  border-color: #cc0066;
	}
</style>
<script type="text/javascript">
	'use strict';

	(function($){
		$(function() {
			var datascource = {
				'name': 'Lao Lao',
				'title': 'general manager',
				'children': [
				{ 'name': 'Bo Miao', 'title': 'department manager', 'className': 'middle-level',
				  'children': [
				    { 'name': 'Li Jing', 'title': 'senior engineer', 'className': 'product-dept' },
				    { 'name': 'Li Xin', 'title': 'senior engineer', 'className': 'product-dept',
				      'children': [
				        { 'name': 'To To', 'title': 'engineer', 'className': 'pipeline1' },
				        { 'name': 'Fei Fei', 'title': 'engineer', 'className': 'pipeline1' },
				        { 'name': 'Xuan Xuan', 'title': 'engineer', 'className': 'pipeline1' }
				      ]
				    }
				  ]
				},
				{ 'name': 'Su Miao', 'title': 'department manager', 'className': 'middle-level',
				  'children': [
				    { 'name': 'Pang Pang', 'title': 'senior engineer', 'className': 'rd-dept' },
				    { 'name': 'Hei Hei', 'title': 'senior engineer', 'className': 'rd-dept',
				      'children': [
				        { 'name': 'Xiang Xiang', 'title': 'UE engineer', 'className': 'frontend1' },
				        { 'name': 'Dan Dan', 'title': 'engineer', 'className': 'frontend1' },
				        { 'name': 'Zai Zai', 'title': 'engineer', 'className': 'frontend1' }
				      ]
				    }
				  ]
				}
				]
			};

			var oc = $('#hierarchy_chart').orgchart({
				'data' : datascource,
				'nodeContent': 'title'
			});
		});
	})(jQuery);
</script>
@endif

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
function showCategorySlider(key)
{
	$('.slider_bank_conatiner').addClass('d-none');
	$('.slider_bank_scroll'+key).removeClass('d-none');

	$('.slider-tab').removeClass('active');
	$('.slider-tab-content'+key).addClass('active');
}

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	@foreach($liabilityCategories as $k => $row)
	$('.slider_bank_scroll{{ $k }}').owlCarousel({
      loop: true,
	  autoplay: true, 	
      margin: 10,
	  autoplayHoverPause: true,
      autoplayTimeout: 2000,
      autoplaySpeed: 1000,	
	  nav: false,
	  dots: true,	
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: false,
		  dots:true,	
        },
        600: {
          items: 2,
          nav: false,
		  dots:true,	
        },
        1000: {
          items: 5,
          nav: false,
		  dots:true,	
          margin: 10
        }
      }
    });
    @endforeach
});
</script>