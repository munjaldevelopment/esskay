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
});
</script>